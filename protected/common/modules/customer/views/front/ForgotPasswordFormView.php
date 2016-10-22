<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use frontend\views\FrontEditView;
use usni\library\utils\FlashUtil;
use usni\UsniAdaptor;
use usni\library\utils\ButtonsUtil;
/**
 * ForgotPasswordFormView class file.
 *
 * @package customer\views\front
 */
class ForgotPasswordFormView extends FrontEditView
{   
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                       'email' => ['type' => 'text'],
                    ];

        $metadata = [
                        'elements' => $elements,
                        'buttons'    => ButtonsUtil::getDefaultButtonsMetadata('customer/site/login', UsniAdaptor::t('application', 'Submit'))
                    ];

        return $metadata;
    }

    /**
     * @inheritdoc
     */
    protected function renderFlashMessages()
    {
        $output     = FlashUtil::render('activationstatusissue', 'alert alert-warning');
        $output    .= FlashUtil::render('forgotpassword',        'alert alert-success');
        $output    .= FlashUtil::render('notregisteredmailid',   'alert alert-danger');
        $output    .= FlashUtil::render('passwordinstructions',  'alert alert-warning');
        return $output;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('users', 'Forgot Password') . '?';
    }
    
    /**
     * @inheritdoc
     */
    protected function renderDescription()
    {
        return '<p style="margin:10px">' . UsniAdaptor::t('customer', 'Enter the e-mail address associated with your account. Click submit to have your information e-mailed to you.') . "</p>";
    }
}