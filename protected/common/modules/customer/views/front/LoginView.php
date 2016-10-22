<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use frontend\views\FrontEditView;
use usni\library\components\UiHtml;
use usni\UsniAdaptor;
/**
 * LoginView class file.
 *
 * @package customer\views\front
 */
class LoginView extends FrontEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'username'   => ['type' => 'text'],
                        'password'   => ['type' => 'password'],
                        'rememberMe' => ['type' => 'checkbox']
                    ];

        $metadata = [
                        'elements'   => $elements,
                        'buttons'    => [
                                         'login'    => UiHtml::getSaveButtonElement(UsniAdaptor::t('users', 'Login')),
                                        ]
                    ];

        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return UiHtml::tag('h2', UsniAdaptor::t('customer', 'Returning Customer'));
    }

    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        $forgotPasswordLink = UiHtml::a(UsniAdaptor::t('users', 'Forgot Password'), UsniAdaptor::createUrl('customer/site/forgot-password'));
        return [
                    'rememberMe' => [
                                        'inputOptions'    => [],
                                        'labelOptions'    => []
                                    ],
                    'password'  =>['template' => "{beginLabel}\n{labelTitle}\n{endLabel}\n{input}\n" . $forgotPasswordLink . "{error}"]
               ];
    }

    /**
     * @inheritdoc
     */
    protected function getButtonsWrapper()
    {
        return "{buttons}";
    }

    /**
     * @inheritdoc
     */
    public function resolveFormViewPath()
    {
        $theme = $this->getTheme();
        return "@webroot/themes/$theme/views/customers/_loginForm";
    }
    
    /**
     * @inheritdoc
     */
    protected function renderDescription()
    {
        return '<p><strong>' . UsniAdaptor::t('customer', 'I am a returning customer') . '</strong></p>';
    }
    
    /**
     * @inheritdoc
     */
    public static function getFormLayout()
    {
        return 'default';
    }
    
    /**
     * @inheritdoc
     */
    protected function getDefaultAttributeTemplate()
    {
        return "{beginLabel}\n{labelTitle}\n{endLabel}\n{input}\n{error}";
    }
}
?>