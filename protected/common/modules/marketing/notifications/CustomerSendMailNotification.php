<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\marketing\notifications;

use newsletter\models\Newsletter;
use usni\library\modules\notification\models\Notification;
use usni\UsniAdaptor;
use common\modules\stores\dao\StoreDAO;
use common\modules\marketing\models\SendMailForm;
use usni\library\notifications\EmailNotification;
/**
 * CustomerSendMailNotification class file.
 * 
 * @package common\modules\marketing\notifications
 */
class CustomerSendMailNotification extends EmailNotification
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
        //@vikash TODO need to the add the language here when using it or pass newsletter attay having store name here.
        $store = StoreDAO::getById($this->model->store_id, $this->language);
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