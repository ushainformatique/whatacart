<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views;

use usni\library\components\UiGridView;
use usni\UsniAdaptor;
use usni\library\modules\auth\managers\AuthManager;
use usni\library\modules\users\models\User;
use customer\components\CustomerActionColumn;
use usni\library\components\UiHtml;
use usni\library\utils\TimezoneUtil;
use customer\widgets\CustomerNameDataColumn;
use customer\widgets\CustomerGridViewActionToolBar;
use customer\models\Customer;
/**
 * CustomerGridView class file.
 * @package customer\views
 */
class CustomerGridView extends UiGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    { 
        $filterParams = UsniAdaptor::app()->request->get($this->getFilterModelClass());
        $columns = [
            [
                'attribute' => 'username',
                'class'     => CustomerNameDataColumn::className()
            ],
            [
                'label'     => UsniAdaptor::t('users', 'Email'),
                'attribute' => 'person.email',
                'filter'    => UiHtml::textInput(UiHtml::getInputName($this->filterModel, 'email'), $filterParams['email'], $this->getDefaultFilterOptions())
            ],
            [
                'label'     => UsniAdaptor::t('users', 'First Name'),
                'attribute' => 'person.firstname',
                'filter'    => UiHtml::textInput(UiHtml::getInputName($this->filterModel, 'firstname'), $filterParams['firstname'], $this->getDefaultFilterOptions())
            ],
            [
                'label' => UsniAdaptor::t('users', 'Last Name'),
                'attribute' => 'person.lastname',
                'filter'    => UiHtml::textInput(UiHtml::getInputName($this->filterModel, 'lastname'), $filterParams['lastname'], $this->getDefaultFilterOptions())
            ],
            [
                'attribute' => 'timezone',
                'filter'    => TimezoneUtil::getTimezoneSelectOptions()
            ],
            [
                'attribute' => 'address.address1',
                'filter'    => UiHtml::textInput(UiHtml::getInputName($this->filterModel, 'address1'), $filterParams['address1'], $this->getDefaultFilterOptions())
            ],
            [
                'attribute' => 'status',
                'class'     => 'usni\library\modules\users\widgets\UserStatusDataColumn',
                'filter'    => User::getStatusDropdown()
            ],
            [
                'class'     => $this->resolveActionColumnClassName(),
                'template'  => $this->resolveActionTemplate()
            ],
        ];
        return $columns;
    }

    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return UsniAdaptor::t('application', 'Manage') . ' ' . Customer::getLabel(2);
    }

    /**
     * @inheritdoc
     */
    protected function resolveDataProviderSort()
    {
        return [
                'defaultOrder' => ['username' => SORT_ASC],
                'attributes'   => ['username', 'person.email', 'person.firstname', 'person.lastname', 'timezone', 'status',
                                   'address.address1']
               ];
    }

    /**
     * Should checkbox for the row be disabled.
     * @param int $row
     * @param Model $data
     * @return boolean
     */
    protected function shouldCheckBoxBeDisabled($data, $row)
    {
        $user           = UsniAdaptor::app()->user->getUserModel();
        if($user->id == $data->id || $user->id == $data->created_by)
        {
            if(AuthManager::checkAccess($user, 'customer.update') || AuthManager::checkAccess($user, 'customer.delete'))
            {
                return false;
            }
        }
        else
        {
            if(AuthManager::checkAccess($user, 'customer.updateother') || AuthManager::checkAccess($user, 'customer.deleteother'))
            {
                return false;
            }
        }
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public static function getGridViewActionToolBarClassName()
    {
        return CustomerGridViewActionToolBar::className();
    }
    
    /**
     * @inheritdoc
     */
    protected static function getActionToolbarOptions()
    {
        $content = parent::getActionToolbarOptions();
        $content['showBulkDelete'] = false;
        return $content;
    }
    
    /**
     * Resolve action column class name.
     * @return string
     */
    protected function resolveActionColumnClassName()
    {
        return CustomerActionColumn::className();
    }
    
    /**
     * Resolve action template.
     * @return string
     */
    protected function resolveActionTemplate()
    {
        return '{view} {update} {delete} {changepassword} {changestatus}';
    }
}
?>