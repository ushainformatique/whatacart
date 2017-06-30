<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\models;
    
use usni\library\db\ActiveRecord;
/**
 * OrderStatusTranslated class file.
 * 
 * @package common\modules\localization\modules\orderstatus\models
 */
class OrderStatusTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getOrder()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'owner_id']);
    }
}