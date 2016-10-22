<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views;

use usni\library\modules\users\views\UserBrowseModelView;
use usni\library\modules\users\utils\UserUtil;
use usni\UsniAdaptor;
/**
 * CustomerDetailBrowseModelView class file.
 *
 * @package customer\views
 */
class CustomerDetailBrowseModelView extends UserBrowseModelView
{
    /**
     * @inheritdoc
     */
    protected function resolveDropdownData()
    {
        return UserUtil::getBrowseByDropDownOptions($this->model, $this->attribute, 'customer.viewother', UsniAdaptor::app()->user->getUserModel());
    }
    
    /**
     * @inheritdoc
     */
    protected function unsetNotAllowed(& $data)
    {
        unset($data[$_GET['id']]);
    }
}