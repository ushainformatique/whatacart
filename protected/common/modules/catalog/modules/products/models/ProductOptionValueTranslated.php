<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;
    
use usni\library\db\ActiveRecord;
/**
 * ProductOptionValueTranslated class file
 * @package common\modules\products\models
 */
class ProductOptionValueTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getProductOptionValue()
    {
        return $this->hasOne(ProductOptionValue::className(), ['id' => 'owner_id']);
    }
}
?>