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
 * ProductSpecialsView class file.
 * @package products\views
 */
class ProductSpecialsView extends SpecialView
{
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $productSpecials            = ProductUtil::getProductSpecials($this->product->id);
        $filePath                   = $this->getFilePath();
        $mainFilePath               = $this->getMainFilePath();
        $rowContent                 = null;
        $language                   = UsniAdaptor::app()->languageManager->getContentLanguage();
        foreach($productSpecials as $index => $productSpecial)
        {
            $customerGroup   = GroupTranslated::find()->where('owner_id = :id AND language = :lang', 
                                                             [':id' => $productSpecial['group_id'], ':lang' => $language])->asArray()->one();
            $rowContent .= $this->getView()->renderPhpFile($filePath, ['customer_group' => $customerGroup['name'],
                                                                       'priority' => $productSpecial['priority'],
                                                                       'price'    => $productSpecial['price'],
                                                                       'start_datetime' => $productSpecial['start_datetime'],
                                                                       'end_datetime'   => $productSpecial['end_datetime']]);
        }
        $content  = $this->getView()->renderPhpFile($mainFilePath, ['rows' => $rowContent]);
        return $content;
    }
    
    /**
     * @inheritdoc
     */
    protected function getFilePath()
    {
        return UsniAdaptor::getAlias('@products/views/_productViewSpecialRow') . '.php';
    }
    
    /**
     * @inheritdoc
     */
    protected function getMainFilePath()
    {
        return UsniAdaptor::getAlias('@products/views/_productViewSpecialValues') . '.php';
    }
}