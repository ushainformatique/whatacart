<?php
use usni\UsniAdaptor;
use usni\library\bootstrap\TabbedActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\widgets\Tabs;
use usni\library\widgets\TabbedActiveFormAlert;
use usni\library\utils\ArrayUtil;

/* @var $formDTO \customer\dto\FormDTO */
/* @var $form \usni\library\bootstrap\TabbedActiveForm */
/* @var $this \usni\library\web\AdminView */

?>
<?php

if($formDTO->getScenario() == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('customer', 'Customer');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('customer', 'Customer');
}
$errors = ArrayUtil::merge($formDTO->getModel()->errors, $formDTO->getPerson()->errors, $formDTO->getAddress()->errors);
echo TabbedActiveFormAlert::widget(['model' => $formDTO->getModel(), 'errors' => $errors]);
$form = TabbedActiveForm::begin([
                                    'id'          => 'customereditview', 
                                    'layout'      => 'horizontal',
                                    'options'     => ['enctype' => 'multipart/form-data'],
                                    'caption'     => $caption
                               ]); 
            $items[] = [
                'options' => ['id' => 'tabuser'],
                'label' => UsniAdaptor::t('application', 'General'),
                'class' => 'active',
                'content' => $this->render('/_customeredit', ['form' => $form, 'formDTO' => $formDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabperson'],
                'label' => UsniAdaptor::t('users', 'Person'),
                'content' => $this->render('@usni/library/modules/users/views/_personedit', 
                                            ['form' => $form, 'formDTO' => $formDTO, 'deleteUrl' => UsniAdaptor::createUrl('customer/default/delete-image')])
            ];
            $items[] = [
                'options' => ['id' => 'tabaddress'],
                'label' => UsniAdaptor::t('users', 'Address'),
                'content' => $this->render('@usni/library/modules/users/views/_addressedit', ['formDTO' => $formDTO, 'form' => $form])
            ];
            echo Tabs::widget(['items' => $items]);
    ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('customer/default/index')]);?>
<?php TabbedActiveForm::end();