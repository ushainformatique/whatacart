<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
/* @var $this \usni\library\web\AdminView */
/* @var $model \common\modules\order\models\Order */

use usni\library\bootstrap\BulkEditActiveForm;
use common\modules\order\models\Order;
use usni\library\bootstrap\BulkEditFormButton;
use usni\UsniAdaptor;

$model  = new Order(['scenario' => 'bulkedit']);
$form = BulkEditActiveForm::begin([
            'id'        => 'orderbulkeditview',
            'layout'    => 'horizontal',
            'caption' => UsniAdaptor::t('order', 'Order') . ' ' . UsniAdaptor::t('application', 'Bulk Edit')
        ]);
?>
<?= $form->field($model, 'status')->select2Input($statusDropdown, false);?>
<?= BulkEditFormButton::widget();?>
<?php
BulkEditActiveForm::end();