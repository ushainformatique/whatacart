<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
/* @var $this \usni\library\web\AdminView */

use usni\library\bootstrap\BulkEditActiveForm;
use usni\library\utils\StatusUtil;
use usni\library\bootstrap\BulkEditFormButton;
use usni\UsniAdaptor;
use productCategories\models\ProductCategory;

$model  = new ProductCategory(['scenario' => 'bulkedit']);
$form = BulkEditActiveForm::begin([
            'id'        => 'productcategorybulkeditview',
            'layout'    => 'horizontal',
            'caption' => UsniAdaptor::t('productCategories', 'Product Category') . ' ' . UsniAdaptor::t('application', 'Bulk Edit')
        ]);
?>
<?= $form->field($model, 'status')->select2Input(StatusUtil::getDropdown(), false);?>
<?= BulkEditFormButton::widget();?>
<?php
BulkEditActiveForm::end();