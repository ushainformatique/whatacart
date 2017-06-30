<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\dataCategories\models;
    
use usni\library\db\ActiveRecord;

/**
 * DataCategoryTranslated class file.
 * 
 * @package common\modules\dataCategories\models
 */
class DataCategoryTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getDataCategory()
    {
        return $this->hasOne(DataCategory::className(), ['id' => 'owner_id']);
    }
}