<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\models;
    
use usni\library\db\ActiveRecord;

/**
 * CountryTranslated class file.
 * 
 * @package common\modules\localization\modules\country\models
 */
class CountryTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'owner_id']);
    }
}