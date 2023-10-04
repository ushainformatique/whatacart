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

$model          = $formDTO->getModel();
$title          = UsniAdaptor::t('settings', 'Site Settings');
$this->title    = $this->params['breadcrumbs'][] = $title;
$form = TabbedActiveForm::begin([
        'id' => 'sitesettingsview',
        'layout' => 'horizontal',
        'options' => ['enctype' => 'multipart/form-data'],
        'caption' => $title
    ]);
?>
<?php
            $items[] = [
                'options' => ['id' => 'tabsite'],
                'label' => UsniAdaptor::t('application','Site'),
                'class' => 'active',
                'content' => $this->render('/_site', ['form' => $form, 'formDTO' => $formDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabfront'],
                'label' => UsniAdaptor::t('application','Front'),
                'content' => $this->render('/_front', ['form' => $form, 'formDTO' => $formDTO])
            ];
            echo Tabs::widget(['items' => $items]);
    ?>
<?= FormButtons::widget(['showCancelButton' => false]);?>
<?php TabbedActiveForm::end();