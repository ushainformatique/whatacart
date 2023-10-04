<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */

/* @var $this \usni\library\web\AdminView */

use usni\UsniAdaptor;
use usni\library\modules\users\models\User;
use usni\library\modules\users\utils\UserUtil;
use usni\library\utils\TimezoneUtil;
use usni\library\modules\users\models\Address;
use usni\library\utils\CountryUtil;
use usni\library\bootstrap\BulkEditActiveForm;
use usni\library\bootstrap\BulkEditFormButton;

/* @var $this \usni\library\web\AdminView */

$userModel      = new User(['scenario' => 'bulkedit']);
$addressModel   = new Address(['scenario' => 'bulkedit']);
$form = BulkEditActiveForm::begin([
            'id' => 'userbulkeditview',
            'layout' => 'horizontal',
            'caption' => UsniAdaptor::t('users', 'User') . ' ' . UsniAdaptor::t('application', 'Bulk Edit'),
        ]);
?>
<?= $form->field($userModel, 'status')->select2Input(UserUtil::getStatusDropdown(), false);?>
<?= $form->field($userModel, 'timezone')->select2Input(TimezoneUtil::getTimezoneSelectOptions());?>
<?= $form->field($userModel, 'groups')->select2input($groupList, true, ['multiple'=>'multiple']);?>
<?= $form->field($addressModel, 'city')->textInput();?>
<?= $form->field($addressModel, 'state')->textInput();?>
<?= $form->field($addressModel, 'country')->select2Input(CountryUtil::getCountries());?>
<?= $form->field($addressModel, 'postal_code')->textInput();?>
<?= BulkEditFormButton::widget();?>
<?php
BulkEditActiveForm::end();