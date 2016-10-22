<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\notifications;

use newsletter\models\Newsletter;
use usni\library\components\UiEmailNotification;
use usni\library\modules\notification\models\Notification;
use usni\UsniAdaptor;
use common\modules\stores\utils\StoreUtil;
use usni\library\modules\notification\utils\NotificationUtil;
/**
 * CustomerNewsletterNotification class file.
 * @package newsletter\notifications
 */
class CustomerNewsletterNotification extends UiEmailNotification
{
    /**
     * Contain newsletter model.
     * @var Newsletter
     */
    public $newsletter;
    
    /**
     * Contain customer to address.
     * @var string 
     */
    public $toAddress;
    
    /**
     * @inheritdoc
     */
    public function getKey()
    {
        return Newsletter::NOTIFY_SENDNEWSLETTER;
    }

    /**
     * @inheritdoc
     */
    public function getModuleName()
    {
        return 'newsletter';
    }

    /**
     * @inheritdoc
     */
    public function getDeliveryPriority()
    {
        return Notification::PRIORITY_NORMAL;
    }

    /**
     * @inheritdoc
     */
    protected function getTemplateData()
    {        
        $store = StoreUtil::getStoreById($this->newsletter->store_id);
        return [
                    '{{appname}}'       => UsniAdaptor::app()->name,
                    '{{storename}}'     => $store['name'],
                    '{{subject}}'       => $this->newsletter->subject,
                    '{{message}}'       => $this->newsletter->content,
                    '{{unsubscribe}}'   => $this->getUnsubscribeUrl()
               ];
    }

    /**
     * @inheritdoc
     */
    protected function getLayoutData($data)
    {
        return array('{{####content####}}' => $data['templateContent']);
    }
    
    /**
     * Get unsubscribe url.
     * @return string
     */
    protected function getUnsubscribeUrl()
    {
        $url                = '/newsletter/site/unsubscribe-newsletter';
        $email              = $this->toAddress;
        $baseUrl            = NotificationUtil::getApplicationBaseUrlUsedForNotification();
        $unsubscribeUrl     = $baseUrl . $url . '?email=' . $email;
        $unsubscribeUrl     = str_replace('backend/', '', $unsubscribeUrl);
        $unsubscribeUrl     = "<a href='$unsubscribeUrl'>" . UsniAdaptor::t('newsletter', 'Unsubscribe') . "</a>";
        return $unsubscribeUrl;
    }
}
?>