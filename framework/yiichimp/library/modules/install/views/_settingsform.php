<?php
use usni\UsniAdaptor;
use usni\library\bootstrap\TabbedActiveForm;
use usni\library\widgets\TabbedActiveFormAlert;
use usni\library\widgets\Tabs;
use usni\library\bootstrap\FormButtons;

/* @var $formDTO \usni\library\modules\install\dto\InstallFormDTO */
/* @var $this \usni\library\web\AdminView */

$model      = $formDTO->getModel();
$this->title = UsniAdaptor::t('install', 'System Settings');
?>
<div class="bs-callout bs-callout-info fade in">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h5><?php echo UsniAdaptor::t('install', 'Instructions');?></h5>
    <ul>
        <li><?php echo UsniAdaptor::t('install', 'Please take up the backup of database if existing database is used');?></li>
        <li><?php echo UsniAdaptor::t('install', 'Populate database admin username and password if you are using a new database and application would create it.');?></li>
        <li><?php echo UsniAdaptor::t('install', 'If you have the database created with username and password, no need to provide admin username and password. Please provide correct database credentials.');?> </li>
    </ul>
</div>
<?php
echo TabbedActiveFormAlert::widget(['model' => $formDTO->getModel()]);
$form = TabbedActiveForm::begin([
                                'id'          => 'installsettingsview', 
                                'layout'      => 'horizontal',
                                'options'     => ['enctype' => 'multipart/form-data'],
                                'caption'     => $this->title
                            ]);
?>
<?php
$items[] = [
                'options' => ['id' => 'tabsite'],
                'label' => UsniAdaptor::t('application','Site'),
                'class' => 'active',
                'content' => $this->render('/_siteform', ['form' => $form, 'formDTO' => $formDTO])
            ];
$items[] = [
                'options' => ['id' => 'tabdatabase'],
                'label' => UsniAdaptor::t('application','Database'),
                'content' => $this->render('/_dbform', ['form' => $form, 'formDTO' => $formDTO])
            ];
echo Tabs::widget(['items' => $items]);
?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('install/default/check-system'),
                         'submitButtonLabel' => UsniAdaptor::t('application', 'Continue')]);?>
<?php TabbedActiveForm::end();