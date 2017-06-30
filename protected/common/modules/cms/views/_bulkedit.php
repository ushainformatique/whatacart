<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
/* @var $this \usni\library\web\AdminView */
/* @var $model \common\modules\cms\models\Page */

use usni\library\bootstrap\BulkEditActiveForm;
use common\modules\cms\models\Page;
use usni\library\bootstrap\BulkEditFormButton;
use usni\UsniAdaptor;
use common\modules\cms\utils\DropdownUtil;

$model          = new Page(['scenario' => 'bulkedit']);
$form = BulkEditActiveForm::begin([
            'id'        => 'pagebulkeditview',
            'layout'    => 'horizontal',
            'caption' => UsniAdaptor::t('cms', 'Page') . ' ' . UsniAdaptor::t('application', 'Bulk Edit')
        ]);
?>
<?= $form->field($model, 'status')->select2Input(DropdownUtil::getStatusSelectOptions(), false);?>
<?= BulkEditFormButton::widget();?>
<?php
BulkEditActiveForm::end();