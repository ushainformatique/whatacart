<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace frontend\business;

use products\dao\ProductDAO;
use frontend\dto\HomePageDTO;
use products\behaviors\ProductBehavior;
use common\modules\stores\business\ConfigManager;
use products\models\Product;
use common\modules\stores\dao\StoreDAO;
/**
 * Business manager for home page
 *
 * @package frontend\business
 */
class HomeManager extends \common\business\Manager
{
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            'productBehavior' => ['class' => ProductBehavior::className()]
        ];
    }
    
    /**
     * Set data for the home page
     * @param HomePageDTO $homePageDTO
     * @return array
     */
    public function setPageData($homePageDTO)
    {
        $itemsPerPage       = ConfigManager::getInstance()->getSettingValue('catalog_items_per_page');
        $dataCategoryId     = StoreDAO::getDataCategoryId($this->selectedStoreId);
        $latestProducts     = ProductDAO::geLatestStoreProducts($dataCategoryId, $this->language, Product::STATUS_ACTIVE, $itemsPerPage);
        
        foreach($latestProducts as $index => $latestProduct)
        {
            $finalPriceExcludingTax                 = $this->getFinalPrice($latestProduct);
            $latestProduct['finalPriceExcludingTax']= $finalPriceExcludingTax;
            $latestProduct['tax']                   = $this->getTaxAppliedOnProduct($latestProduct, $finalPriceExcludingTax);
            $latestProduct['requiredOptionsCount']  = $this->getRequiredOptionsCount($latestProduct['id']);
            $latestProducts[$index] = $latestProduct;
        }
        $homePageDTO->setLatestProducts($latestProducts);
    }
}
