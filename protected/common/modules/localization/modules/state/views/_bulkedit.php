<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

/* @var $this \usni\library\web\AdminView */
/* @var $model \common\modules\localization\modules\state\models\State */

use usni\library\bootstrap\BulkEditActiveForm;
use usni\library\utils\StatusUtil;
use usni\library\bootstrap\BulkEditFormButton;
use usni\UsniAdaptor;
use common\modules\localization\modules\state\models\State;

$model  = new State(['scenario' => 'bulkedit']);
$form = BulkEditActiveForm::begin([
            'id'        => 'statebulkeditview',
            'layout'    => 'horizontal',
            'caption' => UsniAdaptor::t('state', 'State') . ' ' . UsniAdaptor::t('application', 'Bulk Edit')
        ]);
?>
<?= $form->field($model, 'status')->select2Input(StatusUtil::getDropdown(), false);?>
<?= BulkEditFormButton::widget();?>
<?php
BulkEditActiveForm::end();