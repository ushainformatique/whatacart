<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\models;
    
use usni\library\db\ActiveRecord;

/**
 * ProductCategoryTranslated class file.
 * 
 * @package productCategories\models
 */
class ProductCategoryTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'owner_id']);
    }
}