<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\notifications;

use newsletter\models\Newsletter;
use usni\library\notifications\EmailNotification;
use usni\library\modules\notification\models\Notification;
use usni\UsniAdaptor;
use usni\library\modules\notification\utils\NotificationUtil;
use common\modules\stores\dao\StoreDAO;
/**
 * CustomerNewsletterNotification class file.
 * 
 * @package newsletter\notifications
 */
class CustomerNewsletterNotification extends EmailNotification
{
    /**
     * Contain newsletter model.
     * @var Newsletter
     */
    public $model;
    
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
        //@vikash TODO need to the add the language here when using it or pass newsletter attay having store name here.
        $store = StoreDAO::getById($this->model->store_id, $this->language);
        return [
                    '{{appname}}'       => UsniAdaptor::app()->name,
                    '{{storename}}'     => $store['name'],
                    '{{subject}}'       => $this->model->subject,
                    '{{message}}'       => $this->model->content,
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
        $url                = '/marketing/newsletter/site/unsubscribe-newsletter';
        $email              = $this->toAddress;
        $baseUrl            = NotificationUtil::getApplicationBaseUrl();
        $unsubscribeUrl     = $baseUrl . $url . '?email=' . $email;
        $unsubscribeUrl     = str_replace('backend/', '', $unsubscribeUrl);
        $unsubscribeUrl     = "<a href='$unsubscribeUrl'>" . UsniAdaptor::t('newsletter', 'Unsubscribe') . "</a>";
        return $unsubscribeUrl;
    }
}