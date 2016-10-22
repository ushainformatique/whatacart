<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use usni\UsniAdaptor;
use products\utils\ProductUtil;
use usni\library\modules\auth\models\GroupTranslated;
/**
 * ProductDiscountView class file.
 * @package products\views
 */
class ProductDiscountView extends DiscountView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $productDiscounts           = ProductUtil::getProductDiscounts($this->product->id);
        $filePath                   = $this->getFilePath();
        $mainFilePath               = $this->getMainFilePath();
        $rowContent                 = null;
        $language                   = UsniAdaptor::app()->languageManager->getContentLanguage();
        foreach($productDiscounts as $index => $productDiscount)
        {
            $customerGroup   = GroupTranslated::find()->where('owner_id = :id AND language = :lang', 
                                                             [':id' => $productDiscount['group_id'], ':lang' => $language])->asArray()->one();
            $rowContent .= $this->getView()->renderPhpFile($filePath, ['customer_group' => $customerGroup['name'],
                                                                       'quantity'       => $productDiscount['quantity'],
                                                                       'priority'       => $productDiscount['priority'],
                                                                       'price'          => $productDiscount['price'],
                                                                       'start_datetime' => $productDiscount['start_datetime'],
                                                                       'end_datetime'   => $productDiscount['end_datetime']]);
        }
        $content  = $this->getView()->renderPhpFile($mainFilePath, ['rows' => $rowContent]);
        return $content;
    }
    
    /**
     * @inheritdoc
     */
    protected function getFilePath()
    {
        return UsniAdaptor::getAlias('@products/views/_productViewDiscountRow') . '.php';
    }
    
    /**
     * @inheritdoc
     */
    protected function getMainFilePath()
    {
       return UsniAdaptor::getAlias('@products/views/_productViewDiscountValues') . '.php';
    }
}