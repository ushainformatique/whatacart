<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \common\modules\shipping\dto\FlatShippingFormDTO */

use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use common\modules\shipping\utils\flat\FlatShippingUtil;

$title      = UsniAdaptor::t('shipping', 'Flat Rate Settings');
$model      = $formDTO->getModel();
$zoneData   = $formDTO->getZoneDropdownData();
$this->params['breadcrumbs'] = [
        [
        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
        UsniAdaptor::t('shipping', 'Shipping'),
        'url' => ['/shipping/default/index']
    ],
        [
        'label' => $title
    ]
];
$this->title = $title;
$form = ActiveForm::begin([
        'id' => 'flatrateshippingeditview',
        'layout' => 'horizontal',
        'caption' => $title
    ]);
?>
<?= $form->field($model, 'method_name')->dropDownList(FlatShippingUtil::getMethodNameDropdown()); ?>
<?= $form->field($model, 'price')->textInput(); ?>
<?= $form->field($model, 'type')->select2input(FlatShippingUtil::getTypeDropdown());?>
<?= $form->field($model, 'calculateHandlingFee')->select2input(FlatShippingUtil::getHandlingFeesTypeDropdown());?>
<?= $form->field($model, 'handlingFee')->textInput(); ?>
<?= $form->field($model, 'applicableZones')->select2input(FlatShippingUtil::getShipToApplicableDropdown());?>
<?= $form->field($model, 'specificZones')->select2input($zoneData, true, ['multiple'=>'multiple']);?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('shipping/default/index')]);?>
<?php ActiveForm::end(); ?>
<?php
if($model['applicableZones'] == FlatShippingUtil::SHIP_TO_ALL_ZONES)
{
    $this->registerJs("$(document).ready(function() {
                    $('.field-flatrateeditform-specificzones').hide();
                  });");
}
$this->registerJs("$('body').on('change', '#flatrateeditform-applicablezones', function(){
                    var dropdownVal = $(this).val();
                    if(dropdownVal == 2)
                    {
                        $('.field-flatrateeditform-specificzones').show();
                    }
                    if(dropdownVal == 1)
                    {
                        $('.field-flatrateeditform-specificzones').hide();
                    }
               })");