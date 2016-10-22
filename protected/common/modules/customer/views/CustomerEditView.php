<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views;

use usni\library\modules\users\views\UserEditView;
use usni\library\modules\auth\managers\AuthManager;
use usni\UsniAdaptor;
use usni\library\modules\auth\models\Group;
use usni\library\components\UiHtml;
use usni\library\modules\users\models\User;
use usni\library\components\UiActiveForm;
use usni\library\utils\TimezoneUtil;
use customer\utils\CustomerUtil;
/**
 * CustomerEditView class file.
 *
 * @package customer\views
 */
class CustomerEditView  extends UserEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                            'username'        => ['type' => 'text'],
                            'status'          => UiHtml::getFormSelectFieldOptionsWithNoSearch(User::getStatusDropdown()),
                            'timezone'        => UiHtml::getFormSelectFieldOptions(TimezoneUtil::getTimezoneSelectOptions(),
                                                                                   [], ['placeholder' => UiHtml::getDefaultPrompt()]),
                            'groups'          => $this->getCustomerGroups()
                    ];
        
        if($this->model->scenario == 'create' || $this->model->scenario == 'registration')
        {
            $elements['password']               = ['type' => UiActiveForm::INPUT_PASSWORD];
            $elements['confirmPassword']        = ['type' => UiActiveForm::INPUT_PASSWORD];
        }
        $metadata = [
                        'elements'              => $elements,
                    ];
        return $metadata;
    }
    
    /**
     * Get groups.
     * @return array
     */
    protected function getCustomerGroups()
    {
        $group  = new Group();
        $parent = CustomerUtil::getCustomerGroupByName('Customer');
        return UiHtml::getFormSelectFieldOptions($group->getMultiLevelSelectOptions('name', $parent['id'], '-', true, $this->shouldRenderOwnerCreatedModels()),
                                                                                   [], ['multiple' => true]);
    }


    /**
     * Gets excluded elements by scenario.
     * @return array
     */
    public function getExcludedAttributes()
    {
        $scenario   = $this->model->scenario;
        $customer   = UsniAdaptor::app()->user->getUserModel();
        //For update profile by other groups
        if(($scenario == 'update') && !AuthManager::isSuperUser($customer) && !AuthManager::isUserInAdministrativeGroup($customer))
        {
            return ['groups', 'password', 'confirmPassword'];
        }
        return [];
    }
}