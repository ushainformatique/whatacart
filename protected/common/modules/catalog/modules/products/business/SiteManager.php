<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\business;

use products\models\CompareProducts;
use usni\library\dataproviders\ArrayRecordDataProvider;
use usni\UsniAdaptor;
use common\web\ImageBehavior;
use products\behaviors\PriceBehavior;
use products\behaviors\ProductBehavior;
use products\dao\OptionDAO;
use products\dto\ProductDTO;
use products\dao\ProductDAO;
use products\models\ProductReview;
use products\dao\ProductAttributeDAO;
use products\behaviors\NotificationService;
use products\dao\TagDAO;
use products\models\Product;
use products\events\ReviewEvent;
use common\modules\stores\dao\StoreDAO;
/**
 * Implement business logic related to products in front end
 *
 * @package products\business
 */
class SiteManager extends Manager
{
    use \products\traits\RatingTrait;
    use \products\traits\DimensionTrait;
    use \products\traits\WeightTrait;
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            ImageBehavior::className(),
            PriceBehavior::className(),
            ProductBehavior::className(),
            NotificationService::className()
        ];
    }
    
    /**
     * Prepare compare product list
     * @param CompareProducts $compareProducts
     * @return array
     */
    public function getCompareProductsDataProvider($compareProducts)
    {
        $idListArray = [];
        if(!empty($compareProducts->itemsList))
        {
            foreach($compareProducts->itemsList as $productId)
            {
                $idListArray[] = "'" . $productId . "'"; 
            }
        }
        else
        {
           $idListArray = ['-1']; 
        }
        $idList         = implode(',', $idListArray);
        $tableName      = UsniAdaptor::tablePrefix() . 'product';
        $trTableName    = UsniAdaptor::tablePrefix() . 'product_translated';
        $manufacturerTable      = UsniAdaptor::tablePrefix(). 'manufacturer';
        $query          = new \yii\db\Query();
        $query->select('tp.*, tpt.name, man.name as manufacturerName')
                ->from("$tableName tp")
                ->innerJoin($trTableName  . " tpt", "tp.id = tpt.owner_id AND tpt.language = :lang", [':lang' => $this->language])
                ->leftJoin($manufacturerTable  . " man", 'tp.manufacturer = man.id')
                ->where("tp.id IN ($idList)")
              ;
        $dataProvider   = new ArrayRecordDataProvider([
            'query' => $query,
            'key'   => 'id',
            'sort'  => ['attributes' => ['name', 'model', 'price', 'manufacturer', 'weight']]
        ]);
        $models = $dataProvider->getModels();
        foreach($models as $index => $model)
        {
            $model['displayImage'] = $this->renderImageByStoreSettings($model, 'image', 'compare', 50, 50);
            $model['formattedPrice'] = $this->getFormattedPrice($model['price'], UsniAdaptor::app()->currencyManager->selectedCurrency);
            $model['availability'] = $this->getAvailability($model);
            $model['dimensions']   = $this->getDimensions($model['id']);
            $model['attributes']   = $this->getProductAttributes($model['id']);
            $model['overallRating']   = self::getOverallRating($model['id']);
            $model['convertedWeight'] = $this->getWeight($model['id']);
            $models[$index] = $model;
        }
        $dataProvider->setModels($models);
        return $dataProvider;
    }
    
    /**
     * Populate details for the product
     * @param ProductDTO $productDTO
     */
    public function populateDetails($productDTO)
    {
        $id         = $productDTO->getId();
        $customerId = $this->userId;
        $language   = $this->language;
        $product                        = ProductDAO::getById($id, $language);
        $product['discountToDisplay']   = $this->getDiscountToDisplay($product);
        $product['images']              = $this->processAndGetImages($product);
        $product['relatedProductCount'] = ProductDAO::getRelatedProductsCount($id, $language);
        $product['priceExcludingTax']   = $this->getFinalPrice($product);
        $product['tax']                 = $this->getTaxAppliedOnProduct($product, $product['priceExcludingTax']);
        $product['weight']              = $this->getWeight($product['id']);
        $product['dimensions']          = $this->getDimensions($product['id']);
        $product['availability']        = $this->getAvailability($product);
        $product['allowWishlist']       = UsniAdaptor::app()->storeManager->getSettingValue('allow_wishlist');
        $product['allowCompare']        = UsniAdaptor::app()->storeManager->getSettingValue('allow_compare_products');
        $product['allowReviews']        = UsniAdaptor::app()->storeManager->getSettingValue('allow_reviews');
        $product['allowGuestReviews']   = UsniAdaptor::app()->storeManager->getSettingValue('allow_guest_reviews');
        $product['rating']              = $this->getCustomerRating($product['id'], $customerId);
        //rating
        $product['overallRating']       = self::getOverallRating($product['id'], 0.1);
        if(!empty($product))
        {
            ProductDAO::insertHitsOnProduct($product);
        }
        $productDTO->setProduct($product);
        $productDTO->setReviewListDataProvider($this->getReviewListDataProvider($product['id'], $language));
        
        $groupedAttributes = $this->getGroupedAttributes($product['id']);
        $productDTO->setGroupedAttributes($groupedAttributes);
        $assignedOptions    = OptionDAO::getAssignedOptions($product['id'], $this->language);
        $productDTO->setAssignedOptions($assignedOptions);
        $tags = $this->getProductTags($product['id'], $this->language);
        $productDTO->setTags($tags);
        $this->setRelatedProducts($productDTO);
    }
    
    /**
     * Set related products
     * @param ProductDTO $productDTO
     */
    public function setRelatedProducts($productDTO)
    {
        $latestProducts     = ProductDAO::getRelatedProducts($productDTO->getId(), $this->language);
        foreach($latestProducts as $index => $latestProduct)
        {
            $finalPriceExcludingTax                 = $this->getFinalPrice($latestProduct);
            $latestProduct['finalPriceExcludingTax']= $finalPriceExcludingTax;
            $latestProduct['tax']                   = $this->getTaxAppliedOnProduct($latestProduct, $finalPriceExcludingTax);
            $latestProduct['requiredOptionsCount']  = $this->getRequiredOptionsCount($latestProduct['id']);
            $latestProducts[$index] = $latestProduct;
        }
        $productDTO->setRelatedProducts($latestProducts);
    }
    
    /**
     * Post review for product
     * @param array $attributes
     * @param string $language
     * @return boolean
     */
    public function postReview($attributes, $language)
    {
        $model              = new ProductReview();
        $model->attributes  = $attributes;
        if($model->validate())
        {
            $model->save();
            $model->language = $language;
            $model->saveTranslatedModels();
            $event  = new ReviewEvent(['productReview' => $model]);
            $this->trigger(ProductReview::EVENT_NEW_REVIEW_POSTED, $event);
            return true;
        }
        return false;
    }
    
    /**
     * Get tags for product
     * @param int $productId
     * @param string $language
     * @return array
     */
    public function getProductTags($productId, $language)
    {
        return TagDAO::getProductTags($productId, $language);
    }
    
    /**
     * Get product stored data in database
     * @param int $id
     * @param string $language
     * @return array
     */
    public function getProduct($id, $language)
    {
        return ProductDAO::getById($id, $language);
    }
    
    /**
     * Get price modification by selected options
     * @param array $options
     * @param int $productId
     * @return double
     */
    public function getPriceModificationBySelectedOptions($options, $productId)
    {
        $totalPriceModification = 0;
        if(!empty($options))
        {
            foreach($options as $optionId => $optionValue)
            {
                if(!is_array($optionValue))
                {
                    $mappingDetail = OptionDAO::getOptionMappingDetails($productId, $optionId, $optionValue);
                    if(!empty($mappingDetail))
                    {
                        if($mappingDetail['price_prefix'] == '+')
                        {
                            $totalPriceModification = $totalPriceModification + $mappingDetail['price'];
                        }
                        else
                        {
                            $totalPriceModification = $totalPriceModification - $mappingDetail['price'];
                        }
                    }
                }
                else
                {
                    foreach($optionValue as $value)
                    {
                        $mappingDetail = OptionDAO::getOptionMappingDetails($productId, $optionId, $value);
                        if(!empty($mappingDetail))
                        {
                            if($mappingDetail['price_prefix'] == '+')
                            {
                                $totalPriceModification = $totalPriceModification + $mappingDetail['price'];
                            }
                            else
                            {
                                $totalPriceModification = $totalPriceModification - $mappingDetail['price'];
                            }
                        }
                    }
                }
            }
        }
        return $totalPriceModification;
    }
    
    /**
     * Get review list data provider
     * @param int $productId
     * @param string $language
     * @return ArrayRecordDataProvider
     */
    public function getReviewListDataProvider($productId, $language)
    {
        $prTable        = UsniAdaptor::tablePrefix(). 'product_review';
        $prtTable       = UsniAdaptor::tablePrefix(). 'product_review_translated';
        $custTable      = UsniAdaptor::tablePrefix(). 'customer';
        $personTable    = UsniAdaptor::tablePrefix(). 'person';
        $productTable   = UsniAdaptor::tablePrefix(). 'product';
        $query          = new \yii\db\Query();
        $query->select('pr.*, prt.review, pe.profile_image, pro.created_by as productowner')
              ->from("$prTable pr")
              ->innerJoin("$prtTable prt", 'pr.id = prt.owner_id')
              ->innerJoin("$productTable pro", 'pr.product_id = pro.id')
              ->leftJoin("$custTable cu", 'pr.created_by=cu.id')
              ->leftJoin("$personTable pe", 'cu.person_id = pe.id')
              ->where('pr.product_id = :pid AND pr.status = :status AND pr.product_id = pro.id AND pr.id = prt.owner_id 
                        AND prt.language = :lan',
                     [':pid' => $productId, ':status' => ProductReview::STATUS_APPROVED, ':lan' => $language])
              ->orderBy('pr.created_datetime DESC');
        return new ArrayRecordDataProvider(['query' => $query, 'pagination' => false]);
    }
    
    /**
     * Get attributes grouped by attribute group.
     * @param int $productId
     * @return string $valueContent
     */
    public function getGroupedAttributes($productId)
    {
        $groupedData    = [];
        $data           = ProductAttributeDAO::getAttributesByProduct($productId, $this->language);
        if(count($data) > 0)
        {
            foreach($data as $record)
            {
               $groupedData[$record['attribute_group']][$record['groupName']][] = $record; 
            }
        }
        return $groupedData;
    }
    
    /**
     * @inheritdoc
     */
    public function isValidProductId($productId)
    {
        $dataCategoryId     = StoreDAO::getDataCategoryId($this->selectedStoreId);
        $productIdArray     = [];
        $records            = ProductDAO::getActiveStoreProducts($dataCategoryId);
        foreach ($records as $record)
        {
            $productIdArray[] = $record['id'];
        }
        if(!in_array($productId, $productIdArray))
        {
            return false;
        }
        return true;
    }
}
