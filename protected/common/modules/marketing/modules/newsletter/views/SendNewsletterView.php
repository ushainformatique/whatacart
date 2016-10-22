<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\views;

use usni\library\extensions\bootstrap\views\UiBootstrapModalEditView;
use usni\library\utils\ButtonsUtil;
use usni\UsniAdaptor;
use newsletter\models\NewsletterCustomers;
use newsletter\utils\NewsletterUtil;
use frontend\utils\FrontUtil;
/**
 * SendNewsletterView class file.
 * 
 * @package newsletter\views
 */
class SendNewsletterView extends UiBootstrapModalEditView
{

    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements   = null;
        if(UsniAdaptor::app()->user->isGuest)
        {
            $elements = [
                            'email' => ['type' => 'text'],
                        ];
            $metadata = [
                            'elements' => $elements,
                            'buttons'  => self::getJoinNewsletterButton()
                        ];
        }
        else
        {
            $user               = UsniAdaptor::app()->user->getUserModel();
            $newsletterCustomer = NewsletterCustomers::find()->where('customer_id = :cid', [':cid' => $user->id])->asArray()->one();
            if(empty($newsletterCustomer))
            {
                $subscribeMessage = UsniAdaptor::t('newsletter', 'If you want to subscribe click on submit.');
                $elements = [
                                $subscribeMessage,
                                'is_subscribe' => ['type' => 'hidden', 'value' => true]
                            ];
                $metadata = [
                                'elements' => $elements,
                                'buttons'  => self::getJoinNewsletterButton()
                            ];
            }
            else
            {
                $subscribeMessage = UsniAdaptor::t('newsletter', 'You have already subscribed for the newsletter');
                $elements = [
                                $subscribeMessage
                            ];
                $metadata = [
                                'elements' => $elements
                            ];
            }
        }
        return $metadata;
    }
    
    /**
     * Get join newsletter button.
     * @return array
     */
    public static function getJoinNewsletterButton()
    {
        return [
                    'save'  => ButtonsUtil::getSubmitButton(UsniAdaptor::t('application', 'Submit'), 'newslettersubmit')
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected static function getModalSize()
    {
       return 'modal-lg'; 
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return NewsletterCustomers::className();
    }

    /**
     * Get modal id.
     * @return null|string
     */
    protected static function getModalId()
    {
        return 'sendNewsletterModal';
    }
    
    /**
     * Allow event before rendering content
     * @return boolean
     */
    protected function allowEventBeforeRenderingContent()
    {
        return false;
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        $url        = UsniAdaptor::createUrl('newsletter/site/send');
        $formId     = static::getFormId();
        $modalId    = static::getModalId();
        NewsletterUtil::registerSendNewsletterScripts($this->getView(), $url, $formId, $modalId);
        $currentUrl = UsniAdaptor::app()->request->url;
        $js = "$('#sendNewsletterModal').on('hidden.bs.modal', function () 
                                                                {
                                                                    $(location).attr('href', '{$currentUrl}');
                                                                })";
        $this->getView()->registerJs($js);
    }
    
    /**
     * Get target element id.
     * @return null
     */
    protected static function getTargetElementId()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('newsletter', 'Subscribe Newsletter');
    }
    
    /**
     * Resolve form view path.
     * @return string
     */
    public function resolveFormViewPath()
    {
        $theme = FrontUtil::getThemeName();
        return "@themes/$theme/views/newsletter/_newslettermodalform";
    }
    
    /**
     * @inheritdoc
     */
    protected function getDefaultButtonOptions()
    {
        $options = parent::getDefaultButtonOptions();
        $options['submit'] = array('class' => 'btn btn-success');
        return $options;
    }
}