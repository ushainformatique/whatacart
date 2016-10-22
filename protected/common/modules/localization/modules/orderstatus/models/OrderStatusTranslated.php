<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\models;
    
use usni\library\components\UiSecuredActiveRecord;
/**
 * OrderStatusTranslated class file
 * @package common\modules\localization\modules\orderstatus\models
 */
class OrderStatusTranslated extends UiSecuredActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getOrder()
    {
        return $this->hasOne(OrderStatus::className(), ['id' => 'owner_id']);
    }
}
?>