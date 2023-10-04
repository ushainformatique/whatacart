<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\business;

use usni\library\modules\auth\dao\AuthDAO;
use usni\library\modules\users\dao\UserDAO;
use usni\library\modules\auth\models\Group;
use usni\library\modules\auth\dto\GridViewDTO;
use usni\library\modules\auth\dto\FormDTO;
use usni\UsniAdaptor;
use usni\library\modules\users\models\User;
use usni\library\utils\ArrayUtil;
use usni\library\modules\auth\dto\AssignmentFormDTO;
use usni\library\modules\auth\business\AuthManager;
use usni\library\utils\CacheUtil;
use usni\library\modules\auth\models\AuthAssignmentForm;
use usni\library\modules\auth\models\AuthAssignment;
/**
 * Manager class file.
 * 
 * @package usni\library\modules\auth\business
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * Contain member type.
     * @var string
     */
    public $memberType = 'group';
    
    /**
     * Get list of members.
     * 
     * @param string $groupId
     * return string
     */
    public function getMembersList($groupId)
    {
        $membersId     = [];
        $membersName   = [];
        $groupMembers  = AuthDAO::getMembers($groupId);
        foreach($groupMembers as $groupMember)
        {
            $membersId[] = $groupMember['member_id'];
        }

        foreach($membersId as $id)
        {
            $member         = UserDAO::getById($id);
            $membersName[]  = $member['username'];
        }
        return implode(', ', $membersName);
    }
    
    /**
     * inheritdoc
     */
    public function processList($gridViewDTO)
    {
        /* @var $gridViewDTO GridViewDTO*/
        $group = new Group();
        $gridViewDTO->setLevelFilterData($group->getLevelFilterDropdown());
        parent::processList($gridViewDTO);
    }
    
    /**
     * Process edit.
     * @param FormDTO $formDTO
     */
    public function processEdit($formDTO) 
    {
        parent::processEdit($formDTO);
        $parentDropdownOptions = $this->getMultiLevelSelectOptions($formDTO->getModel());
        $formDTO->setParentDropdownOptions($parentDropdownOptions);
        $formDTO->setGroupMemberOptions($this->getGroupMembersSelectData($this->getModelClassNames()));
    }
    
    /**
     * Get model class names.
     * @return array
     */
    protected function getModelClassNames()
    {
        return [User::className()];
    }
    
    /**
     * Get multi level select options
     * @param Group $model
     * @return array
     */
    public function getMultiLevelSelectOptions($model)
    {
        if($model->isNewRecord)
        {
            $model->created_by = $this->userId;
        }
        $isOthersAllowed  = UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, $this->memberType . '.updateother');
        return $model->getMultiLevelSelectOptions('name', !$isOthersAllowed);
    }
    
    /**
     * Gets group members select data.
     * @return array
     */
    public function getGroupMembersSelectData($modelClassNames)
    {
        $members = [];
        foreach($modelClassNames as $modelClassName)
        {
            $prefix     = strtolower(UsniAdaptor::getObjectClassName($modelClassName));
            $records    = $modelClassName::find()->asArray()->all();
            $records    = ArrayUtil::map($records, 'id', 'username');
            foreach($records as $key => $value)
            {
                $members[$modelClassName::getLabel(2)][$prefix . '-' . $key] = $value;
            }
        }
        return $members;
    }
    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return AuthDAO::getAllGroupsByCategory('system');
    }
    
    /**
     * inheritdoc
     */
    public function processDetail($detailViewDTO)
    {
        parent::processDetail($detailViewDTO);
        $model  = $detailViewDTO->getModel();
        $parent = Group::find()->where('id = :id', [':id' => $model['parent_id']])->asArray()->one();
        $model['parent_name'] = $parent['name'];
        $model['members']     = $this->getMembersList($model['id']);
        $detailViewDTO->setModel($model);
    }
    
    /**
     * Process permissions.
     * @param AssignmentFormDTO $formDTO
     */
    public function processPermissions($formDTO)
    {
        $model      = $formDTO->getModel();
        $postData   = $formDTO->getPostData();
        $type       = AuthManager::TYPE_GROUP;
        $authIdentity   = $model->identity;
        if(isset($postData['AuthAssignmentForm']['identityId']))
        {
            if (!empty($postData['AuthAssignmentForm']['assignments']))
            {
                $model->load($postData);
                if(!empty($model->assignments))
                {
                    UsniAdaptor::app()->authorizationManager->addAssignments($model->assignments, $authIdentity->getAuthName(), $type);
                    $formDTO->setIsTransactionSuccess(true);
                }
            }
            else
            {
                //In case all assignments has to be removed
                UsniAdaptor::app()->authorizationManager->deleteAssignments($authIdentity->getAuthName(), $type);
                $formDTO->setIsTransactionSuccess(true);
            }
        }
        $formDTO->setModel($model);
        $group  = new Group();
        $data   = $this->getMultiLevelSelectOptions($group);
        $formDTO->setIdentityDropdownOptions($data);
        $formDTO->setModulesPermissionCountMap($this->getModulesPermissionCountMap($model));
        $formDTO->setIdentityModuleAssignmentMap($this->getIdentityModuleAssignmentMap($model));
    }
    
    /**
     * Get module permission count map
     * @param AuthAssignmentForm $model
     * @return array
     */
    public function getModulesPermissionCountMap($model)
    {
        $modulePermissionsCountMap = CacheUtil::get('modulePermissionsCountMap');
        if($modulePermissionsCountMap === false)
        {
            $modulePermissionsCountMap = [];
            $modules = array_keys($model->permissions);
            foreach($modules as $moduleId)
            {
                $modulePermissionsCountMap[$moduleId] = UsniAdaptor::app()->authorizationManager->getModulePermissionCount($moduleId);
            }
            CacheUtil::set('modulePermissionsCountMap', $modulePermissionsCountMap);
        }
        return $modulePermissionsCountMap;
    }
    
    /**
     * Get module assignment count map for the identity 
     * @param AuthAssignmentForm $model
     * @return array
     */
    public function getIdentityModuleAssignmentMap($model)
    {
        $type   = $model->identity->getAuthType();
        $name   = $model->identity->getAuthName();
        $identityModuleAssignmentMap = CacheUtil::get("$type-$name-ModuleAssignmentMap");
        if($identityModuleAssignmentMap === false)
        {
            $identityModuleAssignmentMap = [];
            $modules = array_keys($model->permissions);
            foreach($modules as $moduleId)
            {
                $identityModuleAssignmentMap[$moduleId] = AuthAssignment::find()
                                                        ->where('module = :module AND identity_name = :iname AND identity_type = :it', 
                                                                [':iname' => $model->identity->getAuthName(),
                                                                 ':it' => $model->identity->getAuthType(),
                                                                 ':module' => $moduleId])
                                                        ->count();
            }
            CacheUtil::set("$type-$name-ModuleAssignmentMap", $identityModuleAssignmentMap);
        }
        return $identityModuleAssignmentMap;
    }
}