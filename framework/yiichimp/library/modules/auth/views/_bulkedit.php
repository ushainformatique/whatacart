<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */

/* @var $this \usni\library\web\AdminView */
/* @var $model \usni\library\modules\auth\models\Group */

use usni\library\bootstrap\BulkEditActiveForm;
use usni\library\utils\StatusUtil;
use usni\library\modules\auth\models\Group;
use usni\library\bootstrap\BulkEditFormButton;
use usni\UsniAdaptor;

$model  = new Group(['scenario' => 'bulkedit']);
$form = BulkEditActiveForm::begin([
            'id'        => 'groupbulkeditview',
            'layout'    => 'horizontal',
            'caption' => UsniAdaptor::t('auth', 'Group') . ' ' . UsniAdaptor::t('application', 'Bulk Edit')
        ]);
?>
<?= $form->field($model, 'status')->select2Input(StatusUtil::getDropdown(), false);?>
<?= BulkEditFormButton::widget();?>
<?php
BulkEditActiveForm::end();