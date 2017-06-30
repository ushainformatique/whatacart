<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
/* @var $this \usni\library\web\AdminView */
/* @var $model \products\models\Product */

use usni\library\bootstrap\BulkEditActiveForm;
use usni\library\utils\StatusUtil;
use products\models\Product;
use usni\library\bootstrap\BulkEditFormButton;
use usni\UsniAdaptor;

$model  = new Product(['scenario' => 'bulkedit']);
$form = BulkEditActiveForm::begin([
            'id'        => 'productbulkeditview',
            'layout'    => 'horizontal',
            'caption' => UsniAdaptor::t('products', 'Product') . ' ' . UsniAdaptor::t('application', 'Bulk Edit')
        ]);
?>
<?= $form->field($model, 'status')->select2Input(StatusUtil::getDropdown(), false);?>
<?= BulkEditFormButton::widget();?>
<?php
BulkEditActiveForm::end();