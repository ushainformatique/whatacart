<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views;

use usni\UsniAdaptor;
use usni\library\modules\users\views\UserDetailView;
use usni\fontawesome\FA;
use usni\library\modules\auth\managers\AuthManager;
/**
 * CustomerDetailView class file.
 * @package customer\views
 */
class CustomerDetailView extends UserDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = parent::getColumns();
        if (($key = array_search('type', $columns)) !== false) 
        {
            unset($columns[$key]);
        }
        return $columns;
    }

    /**
     * @inheritdoc
     */
    protected function resolveChangePasswordLink()
    {
        return 'customer/default/change-password';
    }

    /**
     * @inheritdoc
     */
    protected function renderDetailModelBrowseView()
    {
        $view   = new CustomerDetailBrowseModelView(['model' => $this->model, 'attribute' => $this->resolveDefaultBrowseByAttribute()]);
        return $view->render();
    }
    
    
    /**
     * @inheritdoc
     */
    protected function getOptionItems()
    {
        $user                   = UsniAdaptor::app()->user->getUserModel();
        $editLink               = null;
        $changePasswordLink     = null;
        $modelPermissionName    = strtolower(UsniAdaptor::getObjectClassName($this->model));
        $passwordLabel          = FA::icon('lock') . "\n" . UsniAdaptor::t('users', 'Change Password');
        $editLabel              = FA::icon('pencil') . "\n" . UsniAdaptor::t('application','Edit');
        if(AuthManager::checkAccess($user, $modelPermissionName . '.update'))
        {
            $editLink   = $this->getEditUrl();
        }
        if(AuthManager::checkAccess($user, $modelPermissionName . '.change-password'))
        {
            $changePasswordLink = UsniAdaptor::createUrl($this->resolveChangePasswordLink(), ['id' => $this->model->id]);
        }
        $linkArray = [];
        if($editLink != null)
        {
            $linkArray[] = ['label' => $editLabel, 'url' => $editLink];
        }
        if($changePasswordLink != null)
        {
            $linkArray[] = ['label' => $passwordLabel, 'url' => $changePasswordLink];
        }
        return $linkArray;
    }
}
?>