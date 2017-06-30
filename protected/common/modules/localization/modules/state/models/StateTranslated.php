<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\models;
    
use usni\library\db\ActiveRecord;
/**
 * StateTranslated class file.
 * 
 * @package common\modules\localization\modules\state\models
 */
class StateTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['id' => 'owner_id']);
    }
}