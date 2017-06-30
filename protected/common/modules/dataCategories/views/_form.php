<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\utils\StatusUtil;
use usni\library\bootstrap\ActiveForm;
use usni\library\bootstrap\FormButtons;
use marqu3s\summernote\Summernote;
use yii\helpers\Html;
use common\modules\dataCategories\models\DataCategory;

/* @var $this \usni\library\web\AdminView */

if($model->scenario == 'create')
{
    $caption = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('dataCategories', 'Data Category');
}
else
{
    $caption = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('dataCategories', 'Data Category');
}
$form = ActiveForm::begin([
        'id' => 'datacategoryeditview',
        'layout' => 'horizontal',
        'caption' => $caption
    ]);
?>
<?= $form->field($model, 'name')->textInput(); ?>
<?= $form->field($model, 'description')->widget(Summernote::className()) ?>
<?php
if($model->scenario === 'update' && $model->id === DataCategory::ROOT_CATEGORY_ID)
{
    echo Html::activeHiddenInput($model, 'status');
}
else
{
    echo $form->field($model, 'status')->dropDownList(StatusUtil::getDropdown());
}
?>
<?= FormButtons::widget(['cancelUrl' => UsniAdaptor::createUrl('dataCategories/default/index')]);?>
<?php ActiveForm::end(); ?>
