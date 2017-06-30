<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
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
            'id'        => 'customergroupbulkeditview',
            'layout'    => 'horizontal',
            'caption' => UsniAdaptor::t('customer', 'Customer Group') . ' ' . UsniAdaptor::t('application', 'Bulk Edit')
        ]);
?>
<?= $form->field($model, 'status')->dropDownList(StatusUtil::getDropdown());?>
<?= BulkEditFormButton::widget();?>
<?php
BulkEditActiveForm::end();