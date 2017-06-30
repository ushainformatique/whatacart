<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;
    
use usni\library\db\ActiveRecord;
/**
 * ProductOptionTranslated class file
 * @package products\models
 */
class ProductOptionTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getProductOption()
    {
        return $this->hasOne(ProductOption::className(), ['id' => 'owner_id']);
    }
}
?>