<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\models\cashondelivery;

use usni\UsniAdaptor;
/**
 * CashOnDeliverySetting class file.
 *
 * @package common\modules\payment\models\cashondelivery
 */
class CashOnDeliverySetting extends \yii\base\Model
{
    /**
     * @var string 
     */
    public $order_status;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    ['order_status', 'required'],
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'order_status'  => UsniAdaptor::t('orderstatus', 'Order Status')
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
                    'order_status'  => UsniAdaptor::t('payment', 'Default order status')
               ];
    }
}
