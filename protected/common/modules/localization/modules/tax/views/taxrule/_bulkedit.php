<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

/* @var $this \usni\library\web\AdminView */
/* @var $model \common\modules\manufacturer\models\Manufacturer */

use usni\library\bootstrap\BulkEditActiveForm;
use taxes\models\TaxRule;
use usni\library\bootstrap\BulkEditFormButton;
use usni\UsniAdaptor;
use taxes\utils\TaxUtil;

$model  = new TaxRule(['scenario' => 'bulkedit']);
$form = BulkEditActiveForm::begin([
            'id'        => 'taxrulebulkeditview',
            'layout'    => 'horizontal',
            'caption' => UsniAdaptor::t('tax', 'Tax Rule') . ' ' . UsniAdaptor::t('application', 'Bulk Edit')
        ]);
?>
<?= $form->field($model, 'based_on')->dropDownList(TaxUtil::getBasedOnDropdown());?>
<?= BulkEditFormButton::widget();?>
<?php
BulkEditActiveForm::end();