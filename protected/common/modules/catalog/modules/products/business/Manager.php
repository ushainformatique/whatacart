<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\business;

use products\dto\FormDTO;
use usni\library\utils\ArrayUtil;
use common\modules\localization\modules\lengthclass\dao\LengthClassDAO;
use common\modules\localization\modules\weightclass\dao\WeightClassDAO;
use products\models\Product;
use common\modules\manufacturer\models\Manufacturer;
use productCategories\models\ProductCategory;
use products\dao\ProductDAO;
use productCategories\business\Manager as ProductCategoryBusinessManager;
use customer\business\Manager as CustomerBusinessManager;
use products\dao\OptionDAO;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
use usni\library\managers\UploadInstanceManager;
use usni\library\utils\FileUploadUtil;
use products\models\ProductImage;
use yii\web\UploadedFile;
use products\dao\DownloadDAO;
use taxes\dao\ProductTaxClassDAO;
use products\dao\TagDAO;
use productCategories\dao\ProductCategoryDAO;
use products\dao\DiscountDAO;
use products\dao\SpecialDAO;
use common\modules\stores\dao\StoreDAO;
use products\models\TagTranslated;
use products\models\LatestProductSearch;
use products\models\ProductDiscount;
use products\models\ProductSpecial;
use yii\helpers\Html;
use yii\base\InvalidParamException;
use products\models\ProductCategoryMapping;
/**
 * Implements functionality related to product
 *
 * @package products\business
 */
class Manager extends \common\business\Manager
{
    use \products\traits\DownloadTrait;
    
    /**
     * inheritdoc
     * @param FormDTO $formDTO
     */
    public function processEdit($formDTO)
    {
        $model    = $formDTO->getModel();
        $isValid  = $this->isValidProductId($model['id']);
        if($model->scenario === 'update' && $isValid == false)
        {
            throw new InvalidParamException(UsniAdaptor::t('products', "Invalid product"));
        }
        parent::processEdit($formDTO);
        $taxClasses = ArrayUtil::map(ProductTaxClassDAO::getAll($this->language), 'id', 'name');
        $formDTO->setTaxClasses($taxClasses);
        //set length classes
        $lengthClasses = ArrayUtil::map(LengthClassDAO::getAll($this->language), 'id', 'name');
        $formDTO->setLengthClasses($lengthClasses);
        //set weight classes
        $weightClasses = ArrayUtil::map(WeightClassDAO::getAll($this->language), 'id', 'name');
        $formDTO->setWeightClasses($weightClasses);
        //Set manufacturers
        $manList = ArrayUtil::map(Manufacturer::find()->asArray()->all(), 'id', 'name');
        $formDTO->setManufacturers($manList);
        //Set product categories
        $catList = ProductCategoryBusinessManager::getInstance(['userId' => $this->userId])->getMultiLevelSelectOptions(new ProductCategory());
        $formDTO->setCategories($catList);
        //Set related products
        $products   = ProductDAO::getAll($this->language);
        $prodList   = ArrayUtil::map($products, 'id', 'name');
        if(!$formDTO->model->isNewRecord)
        {
            unset($prodList[$formDTO->model->id]);
        }
        $formDTO->setRelatedProducts($prodList);
        //Set customer groups
        $groups = CustomerBusinessManager::getInstance()->getGroups();
        $formDTO->setGroups($groups);
        //Set discounts
        $this->setProductDiscounts($formDTO);
        //Set specials
        $this->setProductSpecials($formDTO);
        //Set images
        $this->setProductImages($formDTO);
        
        //Set assigned options
        $modifiedOptions = $this->getAssignedOptions($formDTO->model->id);
        $formDTO->setAssignedOptions($modifiedOptions);
        //Set attribute data provider
        $dataProvider = $this->getAssignedAttributesDataProvider($formDTO->model->id);
        $formDTO->setAttributesDataProvider($dataProvider);
        //Set downloads
        $downloads = ArrayUtil::map(DownloadDAO::getAll($this->language), 'id', 'name');
        $formDTO->setDownloads($downloads);
        $this->populateDefaultValues($formDTO);
    }
    
    /**
     * Set product discounts
     * @param FormDTO $formDTO
     */
    public function setProductDiscounts($formDTO)
    {
        $model = $formDTO->getModel();
        if(!empty($model->discounts))
        {
            $discountModels = [];
            $discounts      = $model->discounts;
            foreach($discounts as $discount)
            {
                $discountModel = new ProductDiscount();
                $discountModel->setAttributes($discount);
                $discountModels[] = $discountModel;
            }
            $formDTO->setDiscounts($discountModels);
        }
        else
        {
            $discounts  = $model->productDiscounts;
            $formDTO->setDiscounts($discounts);
        }    
    }
    
    /**
     * Set product specials
     * @param FormDTO $formDTO
     */
    public function setProductSpecials($formDTO)
    {
        $model = $formDTO->getModel();
        if(!empty($model->specials))
        {
            $specialModels = [];
            $specials  = $model->specials;
            foreach($specials as $special)
            {
                $specialModel = new ProductSpecial();
                $specialModel->setAttributes($special);
                $specialModels[] = $specialModel;
            }
            $formDTO->setSpecials($specialModels);
        }
        else
        {
            $specials  = $model->productSpecials;
            $formDTO->setSpecials($specials);
        }    
    }
    
    /**
     * Set product images
     * @param FormDTO $formDTO
     */
    public function setProductImages($formDTO)
    {
        $model = $formDTO->getModel();
        if(!empty($model->images))
        {
            $imageModels    = [];
            $images         = $model->images;
            foreach($images as $image)
            {
                $imageModel     = new ProductImage();
                $imageModel->setAttributes($image);
                $imageModels[]  = $imageModel;
            }
            $imageModels = ArrayUtil::merge($model->productImages, $imageModels);
            $formDTO->setImages($imageModels);
        }
        else
        {
            $images  = $model->productImages;
            $formDTO->setImages($images);
        }    
    }
    
    /**
     * Populate default values
     * @param FormDTO $formDTO
     */
    public function populateDefaultValues($formDTO)
    {
        $model = $formDTO->model;
        if($model->status === null)
        {
            $model->status = Product::STATUS_ACTIVE;
        }
        if($model->stock_status === null)
        {
            $model->stock_status = Product::IN_STOCK;
        }
        if($model->requires_shipping === null)
        {
            $model->requires_shipping = 1;
        }
        if($model->subtract_stock === null)
        {
            $model->subtract_stock = 1;
        }
        if($model->length_class === null)
        {
            $meter = LengthClassDAO::getByUnit('m', $this->language);
            $model->length_class = $meter['id'];
        }
        if($model->weight_class === null)
        {
            $kg = WeightClassDAO::getByUnit('kg', $this->language);
            $model->weight_class = $kg['id'];
        }
        $formDTO->setModel($model);
    }
    
    /**
     * Get assigned options with values grouped under option for the product
     * @param int $productId
     */
    public function getAssignedOptions($productId)
    {
        $assignedOptions    = OptionDAO::getAssignedOptions($productId, $this->language);
        $modifiedOptions    = [];
        //Group option values data under the option
        foreach($assignedOptions as $record)
        {
            if(ArrayUtil::keyExists($record['optionId'], $modifiedOptions) === false)
            {
                $modifiedOptions[$record['optionId']] = [
                                                            'display_name'  => $record['display_name'],
                                                            'required'      => $record['required'],
                                                            'type'          => $record['type'],
                                                        ];
            }
            $optionValue  = [
                'id'              => $record['id'], //product option mapping id
                'option_value_id' => $record['optionValueId'],
                'option_value_name'  => $record['value'],
                'weight'        => $record['weight'],
                'weight_prefix' => $record['weight_prefix'],
                'price'         => $record['price'],
                'price_prefix'  => $record['price_prefix'],
                'quantity'      => $record['quantity'],
                'subtract_stock' => $record['subtract_stock'],
            ];
            $modifiedOptions[$record['optionId']]['optionValues'][] = $optionValue;
        }
        return $modifiedOptions;
    }
    
    /**
     * Set assigned attributes data provider
     * @param int $productId
     * @return ArrayRecordDataProvider
     */
    public function getAssignedAttributesDataProvider($productId)
    {
        $prAttrMappingTableName = UsniAdaptor::tablePrefix() . 'product_attribute_mapping';
        $prAttributeTableName   = UsniAdaptor::tablePrefix() . 'product_attribute';
        $prAttributeTrTableName = UsniAdaptor::tablePrefix() . 'product_attribute_translated';
        $query                  = new \yii\db\Query();
        $query->select('pam.*, pat.name')->from([$prAttrMappingTableName . ' pam', $prAttributeTableName . ' pa', $prAttributeTrTableName  . ' pat'])
            ->where('pam.product_id = :pid AND pam.attribute_id = pa.id AND pa.id = pat.owner_id AND pat.language = :lan')
            ->params([':pid' => $productId, ':lan' => $this->language]);
        return new ArrayRecordDataProvider(['query' => $query, 'pagination' => false]);
    }
    
    /**
     * @inheritdoc
     */
    public function beforeAssigningPostData($model)
    {
        $model->savedImage = $model->image;
    }

    /**
     * @inheritdoc
     */
    public function beforeModelSave($model)
    {
        if(parent::beforeModelSave($model))
        {
            $isValid    = true;
            $config = [
                            'model'             => $model,
                            'attribute'         => 'image',
                            'uploadInstanceAttribute' => 'uploadInstance',
                            'type'              => 'image',
                            'savedAttribute'    => 'savedImage',
                            'fileMissingError'  => UsniAdaptor::t('application', 'Please upload image'),
                            'required'          => true
                      ];
            $uploadInstanceManager = new UploadInstanceManager($config);
            $result = $uploadInstanceManager->processUploadInstance();
            if($result === false)
            {
                $isValid = $isValid && false;
            }
            //For discount
            if (isset($_POST['ProductDiscount']) && is_array($_POST['ProductDiscount']))
            {
                $productDiscounts   = $model->discounts = $_POST['ProductDiscount'];
                $isValid            = $isValid && $this->validateDiscounts($productDiscounts, $model);
            }
            //For related product
            if (isset($_POST['Product']['relatedProducts']) && is_array($_POST['Product']['relatedProducts']))
            {
                $model->relatedProducts = $_POST['Product']['relatedProducts'];
            }

            //For special
            if (isset($_POST['ProductSpecial']) && is_array($_POST['ProductSpecial']))
            {
                $productSpecials   = $model->specials = $_POST['ProductSpecial'];
                $isValid           = $isValid && $this->validateSpecials($productSpecials, $model);
            }
            //For downloads
            if (isset($_POST['Product']['downloads']) && is_array($_POST['Product']['downloads']))
            {
                $model->downloads = $_POST['Product']['downloads'];
            }
            //For product images
            if (isset($_POST['ProductImage']) && is_array($_POST['ProductImage']))
            {
                $model->productImageData = $_POST['ProductImage'];
            }
            $imageErrors    = $this->validateImageUploads($model);
            if(!empty($imageErrors))
            {
                $isValid = $isValid && false;
            }
            return $isValid;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function afterModelSave($model)
    {
        if($model->image != '')
        {
            $config = [
                        'model'             => $model, 
                        'attribute'         => 'image', 
                        'uploadInstance'    => $model->uploadInstance, 
                        'savedFile'         => $model->savedImage
                      ];
            FileUploadUtil::save('image', $config);
        }
        return true;
    }
    
    /**
     * Validate discounts
     * @param array $productDiscounts
     * @param Product $model
     * @return boolean
     */
    public function validateDiscounts($productDiscounts, $model)
    {
        $isValid = true;
        foreach ($productDiscounts as $index => $productDiscount)
        {
            if(!is_numeric($productDiscount['price']))
            {
                $isValid = false;
                $model->addError('discounts', UsniAdaptor::t('products', 'Discounted price is invalid at row') . ' ' . ($index + 1));
            }
            elseif ($productDiscount['price'] >= $model->price)
            {
                $isValid = false;
                $model->addError('discounts', UsniAdaptor::t('products', 'Discounted price should be less then base price at row') . ' ' . ($index + 1));
            }
            if(!ctype_digit($productDiscount['priority']))
            {
                $isValid = false;
                $model->addError('discounts', UsniAdaptor::t('products', 'Priority is invalid at row') . ' ' . ($index + 1));
            }
            if(!ctype_digit($productDiscount['quantity']))
            {
                $isValid = false;
                $model->addError('discounts', UsniAdaptor::t('products', 'Quantity is invalid at row') . ' ' . ($index + 1));
            }
            if (strtotime($productDiscount['start_datetime']) >= strtotime($productDiscount['end_datetime']))
            {
                $isValid = false;
                $model->addError('discounts', UsniAdaptor::t('products', 'Start date should be less then end date at row') . ' ' . ($index + 1));
            }
        }
        return $isValid;
    }
    
    /**
     * Validate specials
     * @param array $productSpecials
     * @param Product $model
     * @return boolean
     */
    public function validateSpecials($productSpecials, $model)
    {
        $isValid = true;
        foreach ($productSpecials as $index => $productSpecial)
        {
            if(!is_numeric($productSpecial['price']))
            {
                $isValid = false;
                $model->addError('specials', UsniAdaptor::t('products', 'Special price is invalid at row') . ' ' . ($index + 1));
            }
            elseif ($productSpecial['price'] >= $model->price)
            {
                $isValid = false;
                $model->addError('specials', UsniAdaptor::t('products', 'Special price should be less then base price at row') . ' ' . ($index + 1));
            }
            if(!ctype_digit($productSpecial['priority']))
            {
                $isValid = false;
                $model->addError('specials', UsniAdaptor::t('products', 'Priority is invalid at row') . ' ' . ($index + 1));
            }
            if (strtotime($productSpecial['start_datetime']) >= strtotime($productSpecial['end_datetime']))
            {
                $isValid = false;
                $model->addError('specials', UsniAdaptor::t('products', 'Start date should be less then end date at row') . ' ' . ($index + 1));
            }
        }
        return $isValid;
    }
    
    /**
     * Validate image uploads.
     * @param $model Product
     * @return array
     */
    public function validateImageUploads($model)
    {
        $imageData  = $model->productImageData;
        $uploadInstances    = [];
        $imageErrors        = [];
        if(!empty($imageData))
        {
            foreach($imageData as $index => $record)
            {
                if($record['id'] == '-1' || $record['id'] == null)
                {
                    $productImage = new ProductImage(['scenario' => 'create']);
                }
                else
                {
                    $productImage = ProductImage::findOne($record['id']);
                }
                $productImage->uploadInstance = UploadedFile::getInstanceByName("ProductImage[$index][uploadInstance]");
                if($productImage->uploadInstance != null)
                {
                    $productImage->image = FileUploadUtil::getEncryptedFileName($productImage->uploadInstance->name);
                    $productImage->caption  = $record['caption'];
                    if(!$productImage->validate())
                    {
                        //Setting it to null so that user does not get confused becuase name would be displayed but uploaded data would not be there
                        //@see http://www.yiiframework.com/forum/index.php/topic/33889-file-upload-field-becomes-empty/
                        $productImage->image    = null;
                        $errors = $imageErrors[$index]    = $productImage->getErrors();
                        foreach($errors as $attribute => $error)
                        {
                            foreach($error as $value)
                            {
                                $model->addError('images', UsniAdaptor::t('products', 'At row') . ' ' . $index . ' ' . $value);
                            }
                        }
                    }
                    $uploadInstances[$index] = $productImage;
                }
            }
        }
        $model->images = $uploadInstances;
        return $imageErrors;
    }
    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        $dataCategoryId = StoreDAO::getDataCategoryId($this->selectedStoreId);
        return ProductDAO::getStoreProducts($dataCategoryId, $this->language, Product::STATUS_ACTIVE);
    }
    
    /**
     * Check if product id is valid for the current store
     * @param integer $productId
     * @return boolean
     */
    public function isValidProductId($productId)
    {
        $dataCategoryId     = StoreDAO::getDataCategoryId($this->selectedStoreId);
        $count              = ProductCategoryMapping::find()->where('data_category_id = :dci AND product_id = :pr', [':dci' => $dataCategoryId, ':pr' => $productId])->count();
        if(intval($count) > 0)
        {
            return true;
        }
        return false;
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model      = ProductDAO::getById($id, $this->language);
        $taxClass   = ProductTaxClassDAO::getById($model['tax_class_id'], $this->language);
        $model['taxClassName']  = $taxClass['name'];
        $model['tagNames']      = $this->getTags($id);
        $model['lengthClass']   = $this->getLengthClass($model);
        $model['weightClass']   = $this->getWeightClass($model);
        $model['categories'] = $this->getCategories($id);
        $model['relatedProducts'] = $this->getRelatedProducts($id);
        $model['assignedOptions'] = $this->getAssignedOptions($id);
        $model['attributesDataProvider'] = $this->getAssignedAttributesDataProvider($id);
        $model['productDiscounts']  = DiscountDAO::getDiscounts($id);
        $model['productSpecials']   = SpecialDAO::getSpecials($id);
        $model['productImages']     = ProductDAO::getImages($id, $this->language);
        $model['downloads']         = $this->getDownloads($id);
        return $model;
    }
    
    /**
     * Get downloads.
     * @param integer $productId
     * @return string
     */
    public function getDownloads($productId)
    {
        $downloadIds    = $this->getDownloadIds($productId);
        $downloadsArray = [];
        $content        = null;
        foreach($downloadIds as $downloadId)
        {
            $download           = DownloadDAO::getById($downloadId, $this->language);
            $downloadsArray[]   = $download;
        }
        foreach ($downloadsArray as $download)
        {
            $url      = UsniAdaptor::createUrl('catalog/products/download/process', ['id' => $download['id']]);
            $content .= Html::a($download['name'], $url) . str_repeat('&nbsp', 3);
        }
        return $content;
    }
    
    /**
     * Get tags
     * @param int $id
     * @return array
     */
    public function getTags($id)
    {
        $tags       = TagDAO::getProductTags($id, $this->language);
        $tagNames   = [];
        foreach ($tags as $tag)
        {
            $tagNames[] = $tag['name'];
        } 
        return implode(', ', $tagNames);
    }
    
    /**
     * Get length class
     * @param array $record
     * @return string
     */
    public function getLengthClass($record)
    {
        $lengthClass = LengthClassDAO::getById($record['length_class'], $this->language);
        if(!empty($lengthClass))
        {
            return $lengthClass['name'];
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Get weight class
     * @param array $record
     * @return string
     */
    public function getWeightClass($record)
    {
        $weightClass = WeightClassDAO::getById($record['weight_class'], $this->language);
        if(!empty($weightClass))
        {
            return $weightClass['name'];
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Get categories for the product.
     * @param integer $id
     * @return string
     */
    public function getCategories($id)
    {
        $rows           = ProductCategoryDAO::getCategoriesByProduct($id, $this->language);
        $categoryArray  = [];
        foreach ($rows as $row)
        {
            $categoryArray[] = $row['name'];
        }
        if (count($categoryArray) > 0)
        {
            return implode(',', $categoryArray);
        }
        else
        {
            return '';
        }
    }
    
    /**
     * Get relatedProduct for the product.
     * @param integer $id
     * @return string
     */
    public function getRelatedProducts($id)
    {
        $rows = ProductDAO::getRelatedProducts($id, $this->language);
        $relatedProductsArray = array();
        foreach ($rows as $row)
        {
            $relatedProductsArray[] = $row['name'];
        }
        if (count($relatedProductsArray) > 0)
        {
            return implode(', ', $relatedProductsArray);
        }
        else
        {
            return '';
        }
    }
    
    /**
     * Get tag items
     * @param string $query
     * @return array
     */
    public function getTagItems($query)
    {
        $models = TagTranslated::find()->where('name LIKE :name AND language = :lan', [':name' => "%$query%", ':lan' => $this->language])->asArray()->all();
        $items = [];
        if(!empty($models))
        {
            foreach ($models as $model)
            {
                $items[] = ['name' => $model['name']];
            }
        }
        return $items;
    }
    
    /**
     * Process latest products
     * @param \usni\library\dto\GridViewDTO $gridViewDTO
     */
    public function processLatestProducts($gridViewDTO)
    {
        $productSearch = new LatestProductSearch();
        $gridViewDTO->setDataProvider($productSearch->search());
    }
    
    /**
     * @inheritdoc
     */
    public function processDetail($detailViewDTO)
    {
        $model      = $this->loadModel($detailViewDTO->getModelClass(), $detailViewDTO->getId());
        $isValid    = $this->isValidProductId($model['id']);
        if($isValid == false)
        {
            throw new InvalidParamException(UsniAdaptor::t('products', "Invalid product"));
        }
        parent::processDetail($detailViewDTO);
    }
}
