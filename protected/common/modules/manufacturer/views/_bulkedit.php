<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
/* @var $this \usni\library\web\AdminView */
/* @var $model \common\modules\manufacturer\models\Manufacturer */

use usni\library\bootstrap\BulkEditActiveForm;
use usni\library\utils\StatusUtil;
use common\modules\manufacturer\models\Manufacturer;
use usni\library\bootstrap\BulkEditFormButton;
use usni\UsniAdaptor;

$model  = new Manufacturer(['scenario' => 'bulkedit']);
$form = BulkEditActiveForm::begin([
            'id'        => 'manufacturerbulkeditview',
            'layout'    => 'horizontal',
            'caption' => UsniAdaptor::t('manufacturer', 'Manufacturer') . ' ' . UsniAdaptor::t('application', 'Bulk Edit')
        ]);
?>
<?= $form->field($model, 'status')->select2Input(StatusUtil::getDropdown(), false);?>
<?= BulkEditFormButton::widget();?>
<?php
BulkEditActiveForm::end();