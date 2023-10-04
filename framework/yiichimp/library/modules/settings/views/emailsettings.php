<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \usni\library\dto\FormDTO */

use usni\UsniAdaptor;
use usni\library\bootstrap\TabbedActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\widgets\Tabs;


foreach(UsniAdaptor::app()->session->getAllFlashes() as $key => $message)
{
    if($key = 'testEmailSent' || $key == 'emailSettingsSaved')
    {
        echo '<div class="alert alert-success">' . $message . '</div>';
    }
    elseif($key == 'testEmailNotProvided')
    {
        echo '<div class="alert alert-danger">' . $message . '</div>';
    }
}
$model          = $formDTO->getModel();
$title          = UsniAdaptor::t('settings', 'Email Settings');
$this->title    = $this->params['breadcrumbs'][] = $title;
$form = TabbedActiveForm::begin([
        'id' => 'emailsettingsview',
        'layout' => 'horizontal',
        'caption' => $title
    ]);
?>
<?php
            $items[] = [
                'options' => ['id' => 'tabuserinfo'],
                'label' => UsniAdaptor::t('application', 'General'),
                'class' => 'active',
                'content' => $this->render('/_userinfo', ['form' => $form, 'formDTO' => $formDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabsmtpmail'],
                'label' => UsniAdaptor::t('notification', 'SMTP'),
                'content' => $this->render('/_smtp', ['form' => $form, 'formDTO' => $formDTO])
            ];
            echo Tabs::widget(['items' => $items]);
    ?>
<?= FormButtons::widget(['showCancelButton' => false]);?>
<?php TabbedActiveForm::end();