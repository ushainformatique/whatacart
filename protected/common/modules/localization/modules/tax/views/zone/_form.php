<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use yii\helpers\Html;
use usni\library\utils\AdminUtil;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \taxes\dto\ZoneFormDTO */

$model          = $formDTO->getModel();
$countryData    = $formDTO->getCountryDropdownData();
$stateData      = $formDTO->getStateDropdownData();

if($model->is_zip_range == false)
{
    $zipContainerStyle = 'display:block';
    $zipRangeContainerStyle = 'display:none';
}
else
{
    $zipContainerStyle = 'display:none';
    $zipRangeContainerStyle = 'display:block';
}
        
if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('tax', 'Zone');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('tax', 'Zone');
}
$form = ActiveForm::begin([
        'id' => 'zoneeditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'description')->textarea(); ?>
<?= $form->field($model, 'country_id')->select2input($countryData);?>
<?= $form->field($model, 'state_id')->select2input($stateData);?>
<?= $form->field($model, 'is_zip_range')->dropDownList(AdminUtil::getYesNoOptions());?>
<?php
echo Html::beginTag('div', ['id' => 'zipContainer', 'style' => $zipContainerStyle]);
?>
<?= $form->field($model, 'zip')->textInput();?>
<?php
echo Html::endTag('div');
?>
<?php
echo Html::beginTag('div', ['id' => 'zipRangeContainer', 'style' => $zipRangeContainerStyle])
?>
<?= $form->field($model, 'from_zip')->textInput();?>
<?= $form->field($model, 'to_zip')->textInput();?>
<?php
echo Html::endTag('div');
?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('localization/tax/zone/index')]);?>
<?php ActiveForm::end(); ?>

<?php
$url = UsniAdaptor::createUrl('localization/state/default/get-states-by-country');
$this->registerJs("$('#zone-country_id').on('change', function(){
                    var dropDown    = $(this);
                    $.ajax({
                            url: '{$url}',
                            type: 'get',
                            data: 'countryId=' + $(this).val(),
                            beforeSend: function()
                                        {
                                            $.fn.attachLoader('#s2id_zone-country_id');
                                        },
                            success: function(data){
                                $.fn.removeLoader('#s2id_zone-country_id');
                                $('#zone-state_id').html(data);
                            }
                        });

            }) 
            $('#zone-is_zip_range').on('change', function(){
                    var value = $(this).val();
                    if(value == 0)
                    {
                        $('#zipContainer').show();
                        $('#zipRangeContainer').hide();
                    }
                    else
                    {
                        $('#zipContainer').hide();
                        $('#zipRangeContainer').show();
                    }
            })");
