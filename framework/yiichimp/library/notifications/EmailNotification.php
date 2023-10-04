<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\notifications;

use usni\UsniAdaptor;
use Yii;
use yii\log\Logger;
use usni\library\modules\notification\dao\NotificationDAO;
use usni\library\utils\Html;
use usni\library\exceptions\MethodNotImplementedException;
/**
 * EmailNotification class file. Every email notification class should extend from it.
 * 
 * @package usni\library\notifications
 */
abstract class EmailNotification extends \yii\base\Component
{
    /**
     * Email body.
     * @var string
     */
    public $body;
    /**
     * Email subject.
     * @var string
     */
    public $subject;
    /**
     * Notification template associated with the notification.
     * @var array
     */
    public $template = null;
    /**
     * Layout for the notification.
     * @var string
     */
    public $layout = null;
    
    /**
     * Language selected by the user
     * @var string 
     */
    public $language;
    
    /**
     * Class constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->language = UsniAdaptor::app()->languageManager->selectedLanguage;
        $this->setTemplate();
        $this->setLayout();
        $this->setSubject();
        $this->setBody();
    }

    /**
     * Get key for the notification template in the database.
     * @throws MethodNotImplementedException
     * @return string
     */
    public function getKey()
    {
        throw new MethodNotImplementedException(__FUNCTION__, get_class($this));
    }

    /**
     * Check and set if notification template exists for the key.
     * @return void.
     */
    public function setTemplate()
    {
        $record         = NotificationDAO::getTemplateByKey($this->getKey(), $this->language);
        if ($record != false)
        {
            $this->template = $record;
        }
        else
        {
            Yii::error(UsniAdaptor::t('notification', 'The notification template is missing for key: {key}', ['{key}' => $this->getKey()]), Logger::LEVEL_ERROR);
        }
    }

    /**
     * Get template data.
     * @throws MethodNotImplementedException
     */
    protected function getTemplateData()
    {
        throw new MethodNotImplementedException(__FUNCTION__, get_class($this));
    }

    /**
     * Sets the body for the email.
     * @return void
     */
    public function setBody()
    {
        if($this->template != false)
        {
            $this->body = $this->prepareBodyContent();
        }
        else
        {
            $this->body = $this->getDefaultContent();
        }
    }
    
    /**
     * Sets the subject for the email.
     * @return void
     */
    public function setSubject()
    {
        if($this->template != false)
        {
            $this->subject = $this->template['subject'];
        }
        else
        {
            $this->subject = $this->getDefaultSubject();
        }
    }

    /**
     * Gets module name from which notification request is made.
     * @return string
     * @throws MethodNotImplementedException
     */
    public function getModuleName()
    {
        throw new MethodNotImplementedException(__FUNCTION__, get_class($this));
    }

    /**
     * Gets delivery priority.
     * @return int
     * @throws MethodNotImplementedException
     */
    public function getDeliveryPriority()
    {
        throw new MethodNotImplementedException(__FUNCTION__, get_class($this));
    }

    /**
     * Gets the layout for the mail.
     * @return string
     */
    public function setLayout()
    {
        if($this->template != false && isset($this->template['layout_id']) && $this->template['layout_id'] != 0)
        {
            $record     = NotificationDAO::getLayout($this->template['layout_id'], $this->language);
            if($record != false)
            {
                $this->layout   = $record['content'];
            }
        }
    }

    /**
     * Returns default notification content.
     * @return string
     */
    protected function getDefaultContent()
    {
        $content        = null;
        $templateData   = $this->getTemplateData();
        foreach($templateData as $key => $value)
        {
            $content .=  '<tr><td>' . str_replace(array('{' , '}'), array('', ''), $key) . '</td><td>' .
                         $value . '</td></tr>';
        }
        return Html::tag('table', $content, []);
    }

    /**
     * Prepares body.
     * @return string
     */
    protected function prepareBodyContent()
    {
        $templateContent = strtr($this->template['content'], $this->getTemplateData());
        if($this->layout != null)
        {
            return strtr($this->layout, $this->getLayoutData(array('templateContent' => $templateContent)));
        }
        return $templateContent;
    }

    /**
     * Gets layout data.
     * @param array $data
     * @return array
     */
    abstract protected function getLayoutData($data);

    /**
     * Set Subject message.
     * @return string
     */
    public function getDefaultSubject()
    {
        return UsniAdaptor::app()->name . ' | ' . UsniAdaptor::t('notification', 'Default Subject');
    }
}