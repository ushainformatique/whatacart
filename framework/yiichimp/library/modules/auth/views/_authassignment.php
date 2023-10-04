<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\library\modules\auth\models\Group;
use usni\UsniAdaptor;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use usni\library\modules\auth\widgets\SelectPermissions;
use yii\helpers\Url;

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \usni\library\modules\auth\dto\AssignmentFormDTO */

$this->params['breadcrumbs'] = [
                                    [
                                        'label' => Group::getLabel(2),
                                        'url'   => array('/auth/group/index')
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('auth', 'Manage Permissions')
                                    ]
                                ];
$this->title    = UsniAdaptor::t('auth', 'Manage Permissions');
$model          = $formDTO->getModel(); 
$form = ActiveForm::begin([
        'id' => 'authassignmenteditview',
        'layout' => 'horizontal',
        'caption' => $this->title
    ]);
?>
<?= $form->field($model, 'identityId')->select2input($formDTO->getIdentityDropdownOptions(), true); ?>
<?= $form->field($model, 'assignments')->widget(SelectPermissions::className(), 
                                                ['modulesPermissionCountMap' => $formDTO->getModulesPermissionCountMap(),
                                                 'identityModuleAssignmentMap' => $formDTO->getIdentityModuleAssignmentMap()
                                                ])->label(false); ?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('auth/group/index')]);?>
<?php ActiveForm::end();
$url        = Url::to();
$parts      = explode('?', $url);
$script     = "$('#authassignmentform-identityid').on('change', function(){
                var value   = $(this).val();
                if(value != '')
                {
                    var url     = '{$parts[0]}' + '?id='+ $(this).val();
                    window.location.href = url;
                }
               })";
$this->registerJs($script);