<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\models;
    
use usni\library\db\ActiveRecord;
/**
 * CurrencyTranslated class file
 * @package common\modules\localization\modules\currency\models
 */
class CurrencyTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'owner_id']);
    }
}
?>