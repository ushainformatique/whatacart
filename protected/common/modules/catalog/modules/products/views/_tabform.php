<?php
use usni\UsniAdaptor;
use usni\library\bootstrap\TabbedActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\widgets\Tabs;
use dosamigos\datetimepicker\DateTimePickerAsset;
use usni\library\widgets\TabbedActiveFormAlert;

/* @var $formDTO \products\dto\FormDTO */
/* @var $form \usni\library\bootstrap\TabbedActiveForm */
/* @var $this \usni\library\web\AdminView */
/* @var $model \products\models\Product */
DateTimePickerAsset::register($this);
$model      = $formDTO->getModel();
?>
<?php
$scenario = $formDTO->model->scenario;
if($scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('products', 'Product');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('products', 'Product');
}
echo TabbedActiveFormAlert::widget(['model' => $formDTO->getModel()]);
$form = TabbedActiveForm::begin([
                                    'id'          => 'producteditview', 
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
                'options' => ['id' => 'tabdata'],
                'label' => UsniAdaptor::t('products', 'Data'),
                'content' => $this->render('/_dataedit', ['form' => $form, 'formDTO' => $formDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabspec'],
                'label' => UsniAdaptor::t('products', 'Specifications'),
                'content' => $this->render('/_specedit', ['form' => $form, 'formDTO' => $formDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabrelated'],
                'label' => UsniAdaptor::t('products', 'Related'),
                'content' => $this->render('/_relatededit', ['form' => $form, 'formDTO' => $formDTO])
            ];
            $fieldConfig        = $form->fieldConfig;
            $form->fieldConfig  = [
                                    "options"   => [],
                                    "template"  => "{input}\n{error}"
                                  ];
            $items[] = [
                'options' => ['id' => 'tabdiscount'],
                'label' => UsniAdaptor::t('products', 'Discounts'),
                'content' => $this->render('/_discountedit', ['form' => $form, 'formDTO' => $formDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabspecial'],
                'label' => UsniAdaptor::t('products', 'Specials'),
                'content' => $this->render('/_specialedit', ['form' => $form, 'formDTO' => $formDTO])
            ];
            $form->fieldConfig  = [
                                    "options"   => [],
                                    "template"  => "{input}\n{error}"
                                  ];
            $items[] = [
                'options' => ['id' => 'tabimage'],
                'label' => UsniAdaptor::t('products', 'Images'),
                'content' => $this->render('/_imageedit', ['form' => $form, 'formDTO' => $formDTO])
            ];
            if($scenario == 'update')
            {
                $items[] = [
                    'options' => ['id' => 'taboptions'],
                    'label' => UsniAdaptor::t('products', 'Options'),
                    'content' => $this->render('/_manageOptionValues', ['formDTO' => $formDTO])
                ];
                $items[] = [
                    'options' => ['id' => 'tabattributes'],
                    'label' => UsniAdaptor::t('products', 'Attributes'),
                    'content' => $this->render('/_manageAttributes', ['formDTO' => $formDTO])
                ];
            }
            echo Tabs::widget(['items' => $items]);
    ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('catalog/products/default/index')]);?>
<?php TabbedActiveForm::end();?>
<?php
echo $this->render('/_productDiscountDummy', ['groups' => $formDTO->getGroups()]);
echo $this->render('/_productSpecialDummy', ['groups' => $formDTO->getGroups()]);
echo $this->render('/_productImageDummy');
$script     = "$('body').find('.datefield').datetimepicker({autoclose:true, format:'yyyy-mm-dd hh:ii:ss'});";
$this->registerJs($script);
$type   = $formDTO->model->type;
$js     = "$(document).ready(function(){
            var producttype = {$type};
            if(producttype == '2')
            {
                $('.field-product-downloads').show();
                $('.field-product-download_option').show();
            }
            else
            {
                $('.field-product-downloads').hide();
                $('.field-product-download_option').hide();
            }
        })";
$this->registerJs($js);
$js = "$('#product-type').on('change', function(){
            var value = $(this).val();
            if(value == '2')
            {
                $('.field-product-downloads').show();
                $('.field-product-download_option').show();
            }
            else
            {
                $('.field-product-downloads').hide();
                $('.field-product-download_option').hide();
            }
            $('.field-product-downloads').removeClass('has-error');
            $('.field-product-downloads').find('.help-block').html('');
            $('.field-product-download_option').find('.help-block').html('');
        })";
$this->registerJs($js);