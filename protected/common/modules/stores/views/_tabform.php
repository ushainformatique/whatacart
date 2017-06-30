<?php
use usni\UsniAdaptor;
use usni\library\bootstrap\TabbedActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\widgets\Tabs;
use usni\library\widgets\TabbedActiveFormAlert;

/* @var $formDTO \common\modules\stores\dto\FormDTO */
/* @var $form \usni\library\bootstrap\TabbedActiveForm */
/* @var $this \usni\library\web\AdminView */
/* @var $model \common\modules\stores\models\StoreEditForm */

$model      = $formDTO->getModel();
?>
<?php
if($formDTO->getScenario() == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('stores', 'Store');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('stores', 'Store');
}
echo TabbedActiveFormAlert::widget(['model' => $formDTO->getModel()]);
$form = TabbedActiveForm::begin([
                                    'id'          => 'storeeditview', 
                                    'layout'      => 'horizontal',
                                    'caption'     => $caption
                               ]); 
?>
<?php
            $items[] = [
                'options' => ['id' => 'tabgeneral'],
                'label' => UsniAdaptor::t('application', 'General'),
                'class' => 'active',
                'content' => $this->render('/_generaledit', ['form' => $form, 'formDTO' => $formDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabbillingaddress'],
                'label' => UsniAdaptor::t('application', 'Billing Address'),
                'content' => $this->render('/_addressedit', ['form' => $form, 'model' => $formDTO->getModel()->billingAddress])
            ];
            $items[] = [
                'options' => ['id' => 'tabshippingaddress'],
                'label' => UsniAdaptor::t('application', 'Shipping Address'),
                'content' => $this->render('/_shippingaddressedit', ['formDTO' => $formDTO, 'form' => $form])
            ];
            $items[] = [
                'options' => ['id' => 'tablocal'],
                'label' => UsniAdaptor::t('stores', 'Local'),
                'content' => $this->render('/_localedit', ['formDTO' => $formDTO, 'form' => $form])
            ];
            $items[] = [
                'options' => ['id' => 'tabsettings'],
                'label' => UsniAdaptor::t('stores', 'Settings'),
                'content' => $this->render('/_settingsedit', ['formDTO' => $formDTO, 'form' => $form])
            ];
            $items[] = [
                'options' => ['id' => 'tabimage'],
                'label' => UsniAdaptor::t('stores', 'Images'),
                'content' => $this->render('/_imageedit', ['formDTO' => $formDTO, 'form' => $form])
            ];
            echo Tabs::widget(['items' => $items]);
    ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('stores/default/index')]);?>
<?php TabbedActiveForm::end();