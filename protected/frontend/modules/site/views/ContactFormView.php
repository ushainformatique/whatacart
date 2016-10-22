<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\modules\site\views;

use frontend\views\FrontEditView;
use usni\UsniAdaptor;
use usni\library\utils\ButtonsUtil;
use usni\library\components\UiActiveForm;
use yii\captcha\Captcha;
use usni\library\utils\FlashUtil;
/**
 * ContactFormView class file.
 * @package frontend\modules\site\views
 */
class ContactFormView extends FrontEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'          => ['type' => 'text'],
                        'email'         => ['type' => 'text'],
                        'subject'       => ['type' => 'text'],
                        'message'       => ['type' => UiActiveForm::INPUT_TEXTAREA,
                                                 'rows' => 5,
                                                 'placeholder' => UsniAdaptor::t('application', 'Message')],
                        'verifyCode'    => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => Captcha::className(), 
                                            'captchaAction' => '/site/default/captcha']
                    ];
        $metadata = [
                        'elements' => $elements,
                        'buttons'  => [
                                          'save' => ButtonsUtil::getSubmitButton(UsniAdaptor::t('application','Submit')),
                                      ]
                    ];

        return $metadata;
    }

    /**
     * @inheritdoc
     */
    public static function getFormId()
    {
        return 'contactformview';
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return 'Contact Us';
    }
    
    /**
     * @inheritdoc
     */
    protected function renderFlashMessages()
    {
        return FlashUtil::render(['contactMailSuccess', 'contactMailFailure'], ['alert alert-success', 'alert alert-danger']);
    }
    
    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        return ['name' => ['inputOptions' => ['placeholder' => UsniAdaptor::t('application', 'Your name')]],
                'email' => ['inputOptions' => ['placeholder' => UsniAdaptor::t('application', 'Your email')]],
                'subject' => ['inputOptions' => ['placeholder' => UsniAdaptor::t('application', 'Subject')]]
              ];
    }
}
?>