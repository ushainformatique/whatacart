<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\notifications;

use common\modules\order\models\Order;
use usni\library\notifications\EmailNotification;
use usni\library\modules\notification\models\Notification;
use yii\helpers\Url;
use usni\library\utils\DateTimeUtil;
use usni\UsniAdaptor;
/**
 * Notification sent on compeltion of order
 *
 * @package common\modules\order\notifications
 */
class OrderCompletedEmailNotification extends EmailNotification
{
    /**
     * Contain order model.
     * @var array
     */
    public $order;
    
    /**
     * @inheritdoc
     */
    public function getKey()
    {
        return Order::NOTIFY_ORDERCOMPLETION;
    }

    /**
     * @inheritdoc
     */
    public function getModuleName()
    {
        return 'order';
    }
    
    /**
     * @inheritdoc
     */
    public function getDeliveryPriority()
    {
        return Notification::PRIORITY_HIGH;
    }

    /**
     * @inheritdoc
     */
    protected function getTemplateData()
    {
        $orderLink  = null;
        if($this->order['customer_id'] != 0)
        {
            $orderUrlContent = '<p style="margin-top: 0px; margin-bottom: 20px;">To view your order click on the link below:</p>
                                <p style="margin-top: 0px; margin-bottom: 20px;"><a href="{orderLink}">{{orderLink}}</a></p>';
            $orderUrl   = UsniAdaptor::app()->getFrontUrl() . '/customer/site/order-view?id=' . $this->order['id'];
            $orderUrl   = "<a href='$orderUrl'>$orderUrl</a>";
            $orderLink  = str_replace('{{orderLink}}', $orderUrl, $orderUrlContent);
        }
        return [
                    '{{ordernumber}}'       => $this->order['unique_id'],
                    '{{siteurl}}'           => Url::home(true),
                    '{{customername}}'      => $this->order['firstname'] . ' ' . $this->order['lastname'],
                    '{{orderdate}}'         => DateTimeUtil::getFormattedDateTime($this->order['created_datetime']),
                    '{{orderLink}}'         => $orderLink
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getLayoutData($data)
    {
        return array('{{####content####}}' => $data['templateContent']);
    }
}