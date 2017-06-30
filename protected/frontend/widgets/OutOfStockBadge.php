<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\widgets;

use usni\UsniAdaptor;
use products\models\Product;
/**
 * OutOfStockBadge renders out of stock message for the product
 *
 * @package frontend\widgets
 */
class OutOfStockBadge extends \yii\bootstrap\Widget
{
    /**
     * Name of product
     * @var string 
     */
    public $name;
    
    /**
     * @var int 
     */
    public $stockStatus;
    
    /**
     * inheritdoc
     */
    public function run()
    {
        $outOfStockWarningSetting   = UsniAdaptor::app()->storeManager->getSettingValue('show_out_of_stock_warning');
        $outOfStockCheckoutSetting  = UsniAdaptor::app()->storeManager->getSettingValue('allow_out_of_stock_checkout');
        if((!$outOfStockCheckoutSetting) && $outOfStockWarningSetting && $this->stockStatus == Product::OUT_OF_STOCK)
        {
            return $this->name . '<span class="badge">' . UsniAdaptor::t('products', 'Out of Stock') . "</span>";
        }
        else
        {
            return $this->name; 
        }
    }
}
