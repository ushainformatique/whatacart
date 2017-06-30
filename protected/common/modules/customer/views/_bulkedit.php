<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

/* @var $this \usni\library\web\AdminView */

use usni\UsniAdaptor;
use usni\library\modules\users\utils\UserUtil;
use usni\library\utils\TimezoneUtil;
use usni\library\modules\users\models\Address;
use usni\library\utils\CountryUtil;
use usni\library\bootstrap\BulkEditActiveForm;
use usni\library\bootstrap\BulkEditFormButton;
use customer\models\Customer;

/* @var $this \usni\library\web\AdminView */

$customerModel  = new Customer(['scenario' => 'bulkedit']);
$addressModel   = new Address(['scenario' => 'bulkedit']);
$form = BulkEditActiveForm::begin([
            'id' => 'customerbulkeditview',
            'layout' => 'horizontal',
            'caption' => UsniAdaptor::t('customer', 'Customer') . ' ' . UsniAdaptor::t('application', 'Bulk Edit'),
        ]);
?>
<?= $form->field($customerModel, 'status')->select2Input(UserUtil::getStatusDropdown(), false);?>
<?= $form->field($customerModel, 'timezone')->select2Input(TimezoneUtil::getTimezoneSelectOptions());?>
<?= $form->field($customerModel, 'groups')->select2input($groupList, true, ['multiple'=>'multiple']);?>
<?= $form->field($addressModel, 'city')->textInput();?>
<?= $form->field($addressModel, 'state')->textInput();?>
<?= $form->field($addressModel, 'country')->select2Input(CountryUtil::getCountries());?>
<?= $form->field($addressModel, 'postal_code')->textInput();?>
<?= BulkEditFormButton::widget();?>
<?php
BulkEditActiveForm::end();