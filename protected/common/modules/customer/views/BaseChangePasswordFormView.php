<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views;

use usni\UsniAdaptor;
use usni\library\modules\users\views\ChangePasswordView;
use customer\models\Customer;
/**
 * BaseChangePasswordFormView class file.
 *
 * @package customer\views
 */
class BaseChangePasswordFormView extends ChangePasswordView
{
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        $customer = Customer::findOne($_GET['id']);
        return UsniAdaptor::t('users', 'Change Password') . '(' . $customer->username . ')';
    }
    
    /**
     * Get button url
     * @return string
     */
    protected function getButtonUrl()
    {
        return 'customer/site/my-profile';
    }
}
?>