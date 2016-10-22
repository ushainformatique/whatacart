<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;
    
use usni\library\components\UiSecuredActiveRecord;
/**
 * ProductTaxClassTranslated class file
 * @package taxes\models;
 */
class ProductTaxClassTranslated extends UiSecuredActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getProductTaxClass()
    {
        return $this->hasOne(ProductTaxClass::className(), ['id' => 'owner_id']);
    }
}
?>