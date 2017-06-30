<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\utils\Html;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \products\dto\AssignAttributeDTO */

$this->title                = UsniAdaptor::t('products', 'Assign Attributes');
$this->params['breadcrumbs']= [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('products', 'Products'),
                                        'url'   => UsniAdaptor::createUrl('/catalog/products/default/index')
                                    ],
                                    [
                                        'label' => $formDTO->product['name'],
                                        'url'   => UsniAdaptor::createUrl('/catalog/products/default/view', ['id' => $formDTO->product['id']])
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('products', 'Assign Attributes')
                                    ]
                            ];
$model      = $formDTO->model;

$caption    = $this->title;
$form       = ActiveForm::begin([
                    'id' => 'assignproductattributeeditview',
                    'layout' => 'horizontal',
                    'caption' => $caption
                ]);
?>
<?= $form->field($model, 'attribute_id')->select2input($formDTO->getAttributes());?>
<?= Html::activeHiddenInput($model, 'product_id');?>
<?= $form->field($model, 'attribute_value')->textInput(); ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('catalog/products/default/index')]);?>
<?php ActiveForm::end();?>

<?php echo $this->render('/_assignedAttributesGridView', ['dataProvider' => $formDTO->getAttributesDataProvider(),
                                                 'caption' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('application', 'Attributes'),
                                                 'showActionColumn' => true]);?>
<?php
$formId             = 'assignproductattributeeditview';
$pjaxContainerId    = 'assignattributesgridview-pjax';
$url                = UsniAdaptor::createUrl('/catalog/products/attribute/save-assignment');
$productId          = $model['product_id'];
$script             = "$('#{$formId}').on('beforeSubmit',
                             function(event)
                             {
                                var form = $(this);
                                if(form.find('.has-error').length) {
                                        return false;
                                }
                                $.ajax({
                                            url: '{$url}',
                                            type: 'post',
                                            data: 'productId = {$productId}',
                                            beforeSend: function()
                                                        {
                                                            $.fn.attachLoader('#{$formId}');
                                                        },
                                            data: form.serialize()
                                        })
                                .done(function(data, statusText, xhr){
                                                        //Timeout is critical here else pjax expires and
                                                        //and page got refreshed
                                                        $.pjax.reload({container:'#{$pjaxContainerId}', 'timeout':2000});
                                                        $.fn.removeLoader('#{$formId}');
                                                        //remove button loader
                                                        removeButtonLoader($('#{$formId}'));
                                                        $('#productattributemapping-attribute_id').select2('val', null);
                                                        $('#productattributemapping-attribute_value').val(null);
                                                      });

                                        return false;
                             })";
$this->registerJs($script);