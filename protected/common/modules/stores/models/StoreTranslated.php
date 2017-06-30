<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\models;
    
use usni\library\db\ActiveRecord;

/**
 * StoreTranslated class file
 * @package common\modules\dataCategories\models
 */
class StoreTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'owner_id']);
    }
}
?>