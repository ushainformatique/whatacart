<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\marketing\notifications;

use newsletter\models\Newsletter;
use usni\library\components\UiEmailNotification;
use usni\library\modules\notification\models\Notification;
use usni\UsniAdaptor;
use common\modules\stores\utils\StoreUtil;
use common\modules\marketing\models\SendMailForm;
/**
 * CustomerSendMailNotification class file.
 * @package common\modules\marketing\notifications
 */
class CustomerSendMailNotification extends UiEmailNotification
{
    /**
     * Contain send mail model.
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
        return SendMailForm::NOTIFY_SENDMAIL;
    }

    /**
     * @inheritdoc
     */
    public function getModuleName()
    {
        return 'marketing';
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
        $store = StoreUtil::getStoreById($this->model->store_id);
        return [
                    '{{appname}}'       => UsniAdaptor::app()->name,
                    '{{storename}}'     => $store['name'],
                    '{{subject}}'       => $this->model->subject,
                    '{{message}}'       => $this->model->content,
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
?>