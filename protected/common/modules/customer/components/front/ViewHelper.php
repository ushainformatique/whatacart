<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\components\front;

use usni\library\components\BaseViewHelper;
/**
 * ViewHelper class file.
 *
 * @package customer\components
 */
class ViewHelper extends BaseViewHelper
{
    /**
     * Profile edit view
     * @var string 
     */
    public $profileEditView     = 'customer\views\front\CustomerProfileEditView';
    /**
     * Customer edit view
     * @var string 
     */
    public $customerEditView    = 'customer\views\front\CustomerEditView';
    /**
     * Person edit view
     * @var string 
     */
    public $personEditView      = 'customer\views\front\PersonEditView';
    /**
     * Address edit view
     * @var string 
     */
    public $addressEditView     = 'usni\library\modules\users\views\AddressEditView';
    /**
     * Login page view
     * @var string 
     */
    public $loginPageView       = 'customer\views\front\LoginPageView';
    /**
     * My orders view
     * @var string 
     */
    public $myOrdersView        = 'customer\views\front\MyOrdersView';
    /**
     * My orders view
     * @var string 
     */
    public $myProfileView       = 'customer\views\front\MyProfileView';
    /**
     * Sidebar Column View
     * @var string 
     */
    public $sidebarColumnView   = 'customer\views\front\SidebarColumnView';
    /**
     * Change password form view
     * @var string 
     */
    public $changePasswordFormView  = 'customer\views\front\ChangePasswordFormView';
}
?>