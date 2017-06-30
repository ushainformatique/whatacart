<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\weightclass\models;
    
use usni\library\db\ActiveRecord;
/**
 * WeightClassTranslated class file.
 * 
 * @package common\modules\localization\modules\weightclass\models
 */
class WeightClassTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getWeightClass()
    {
        return $this->hasOne(WeightClass::className(), ['id' => 'owner_id']);
    }
}