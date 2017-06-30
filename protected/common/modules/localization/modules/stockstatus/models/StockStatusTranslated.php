<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\stockstatus\models;
    
use usni\library\db\ActiveRecord;

/**
 * StockStatusTranslated class file.
 * 
 * @package common\modules\localization\modules\stockstatus\models
 */
class StockStatusTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getStockStatus()
    {
        return $this->hasOne(StockStatus::className(), ['id' => 'owner_id']);
    }
}