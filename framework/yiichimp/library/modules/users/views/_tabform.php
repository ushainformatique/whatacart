<?php
use usni\UsniAdaptor;
use usni\library\bootstrap\TabbedActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\widgets\Tabs;
use usni\library\widgets\TabbedActiveFormAlert;

/* @var $formDTO \usni\library\modules\users\dto\UserFormDTO */
/* @var $form \usni\library\bootstrap\TabbedActiveForm */
/* @var $this \usni\library\web\AdminView */

$user       = $formDTO->getModel();
$person     = $formDTO->getPerson();
$address    = $formDTO->getAddress();
?>
<?php
if($formDTO->getScenario() == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('users', 'User');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('users', 'User');
}
echo TabbedActiveFormAlert::widget(['model' => $formDTO->getModel()]);
$form = TabbedActiveForm::begin([
                                    'id'          => 'usereditview', 
                                    'layout'      => 'horizontal',
                                    'options'     => ['enctype' => 'multipart/form-data'],
                                    'caption'     => $caption
                               ]); 
?>
<?php
            $items[] = [
                'options' => ['id' => 'tabuser'],
                'label' => UsniAdaptor::t('application', 'General'),
                'class' => 'active',
                'content' => $this->render('/_useredit', ['form' => $form, 'formDTO' => $formDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabperson'],
                'label' => UsniAdaptor::t('users', 'Person'),
                'content' => $this->render('/_personedit', ['form' => $form, 'formDTO' => $formDTO, 'deleteUrl' => UsniAdaptor::createUrl('users/default/delete-image')])
            ];
            $items[] = [
                'options' => ['id' => 'tabaddress'],
                'label' => UsniAdaptor::t('users', 'Address'),
                'content' => $this->render('/_addressedit', ['formDTO' => $formDTO, 'form' => $form])
            ];
            echo Tabs::widget(['items' => $items]);
    ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('users/default/index')]);?>
<?php TabbedActiveForm::end();