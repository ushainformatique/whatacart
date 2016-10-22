<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\lengthclass\models;
    
use usni\library\components\UiSecuredActiveRecord;

/**
 * LengthClassTranslated class file
 * @package common\modules\localization\modules\lengthclass\models
 */
class LengthClassTranslated extends UiSecuredActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getLengthClass()
    {
        return $this->hasOne(LengthClass::className(), ['id' => 'owner_id']);
    }
}
?>