<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\models;
    
use usni\library\db\ActiveRecord;
/**
 * OrderPaymentDetailsTranslated class file
 * @package common\modules\order\models
 */
class OrderPaymentDetailsTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getOrderPaymentDetails()
    {
        return $this->hasOne(OrderPaymentDetails::className(), ['id' => 'owner_id']);
    }
}
?>