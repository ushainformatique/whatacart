<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\services;

use usni\UsniAdaptor;
use common\modules\order\models\Order;
use common\modules\order\notifications\OrderReceivedEmailNotification;
use common\modules\order\events\OrderEvent;
use common\modules\order\notifications\OrderCompletedEmailNotification;
use usni\library\utils\FileUtil;
use common\modules\order\dao\OrderDAO;
use products\models\ProductDownload;
use products\models\ProductDownloadMapping;
/**
 * Send notifications related to order
 *
 * @package common\modules\order\services
 */
class NotificationService extends \usni\library\notifications\BaseNotificationService
{
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
                    Order::EVENT_NEW_ORDER_CREATED  => [$this, 'sendNewOrderEmailNotification'],
                    Order::EVENT_ORDER_COMPLETED    => [$this, 'sendOrderCompletedEmailNotification']
               ];
    }
    
    /**
     * Send new order notification.
     * 
     * @param OrderEvent $event
     * @return boolean
     */
    public function sendNewOrderEmailNotification(OrderEvent $event)
    {
        $this->emailNotification  = new OrderReceivedEmailNotification(['order' => $event->order]);
        $this->to = $event->order['email']; 
        $this->processSend();
    }
    
    /**
     * Send order completed notification.
     * 
     * @param OrderEvent $event
     * @return boolean
     */
    public function sendOrderCompletedEmailNotification(OrderEvent $event)
    {
        $this->emailNotification    = new OrderCompletedEmailNotification(['order' => $event->order]);
        $this->to                   = $event->order['email']; 
        $attachments                = $this->getAttachments($event->order);
        if(!empty($attachments))
        {
            foreach($attachments as $attachment)
            {
                $type = FileUtil::getExtension($attachment['file']);
                if(in_array($type, ['jpg', 'png', 'gif', 'jpeg']))
                {
                    $fileManagerInstance   = UsniAdaptor::app()->assetManager->getResourceManager('image', ['model' => (object)$attachment, 'attribute' => 'file']);
                }
                else
                {
                    $fileManagerInstance   = UsniAdaptor::app()->assetManager->getResourceManager('file', ['model' => (object)$attachment, 'attribute' => 'file']);
                }
                $this->attachments[]   = $fileManagerInstance->getUploadedFilePath();
            }
        }
        $this->processSend();
    }
    
    /**
     * Get attachments.
     * @param array $order
     * @return array
     */
    public function getAttachments($order)
    {
        $downloadIdArray    = [];
        $productDownloads   = [];
        $orderProducts      = OrderDAO::getOrderProducts($order['id'], $this->owner->language);
        foreach ($orderProducts as $orderProduct)
        {
            $downloadIdArray[] = $this->getSendViaMailIds($orderProduct['product_id']);
        }
        if(!empty($downloadIdArray))
        {
            foreach ($downloadIdArray as $downloadIds)
            {
                foreach ($downloadIds as $downloadId)
                {
                    $productDownloads[] = ProductDownload::find()->where('id = :id', [':id' => $downloadId])->asArray()->one();
                }
            }
            return $productDownloads;
        }
    }
    
    /**
     * Get send via mail ids.
     * @param int $id
     * @return Array
     */
    public function getSendViaMailIds($id)
    {
        $relatedDownloadIdArray    = [];
        $relatedDownloadRecords = ProductDownloadMapping::find()->where('product_id = :pId', [':pId' => $id])->asArray()->all();
        if(!empty($relatedDownloadRecords))
        {
            foreach ($relatedDownloadRecords as $record)
            {
                if($record['download_option'] == 'sendviamail')
                {
                    $relatedDownloadIdArray[] = $record['download_id'];
                }
            }
            return array_unique($relatedDownloadIdArray);
        }
        return $relatedDownloadIdArray;
    }
}
