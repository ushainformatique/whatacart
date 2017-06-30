<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;
    
use usni\library\db\ActiveRecord;
/**
 * ProductTranslated class file
 * @package products\models
 */
class ProductTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'owner_id']);
    }
}
?>