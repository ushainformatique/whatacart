<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;
    
use usni\library\db\ActiveRecord;
/**
 * ProductAttributeTranslated class file
 * @package products\models
 */
class ProductAttributeTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getProductAttribute()
    {
        return $this->hasOne(ProductAttribute::className(), ['id' => 'owner_id']);
    }
}
?>