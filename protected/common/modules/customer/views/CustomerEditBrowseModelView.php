<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views;

use usni\library\modules\users\utils\UserUtil;
use usni\UsniAdaptor;
use usni\library\modules\users\views\UserBrowseModelView;
/**
 * Browse model view for customer.
 * 
 * @package customer\views
 */
class CustomerEditBrowseModelView extends UserBrowseModelView
{
    /**
     * Resolve data.
     * @return array
     */
    protected function resolveDropdownData()
    {
        return UserUtil::getBrowseByDropDownOptions($this->model, $this->attribute, 'customer.updateother', UsniAdaptor::app()->user->getUserModel());
    }
}