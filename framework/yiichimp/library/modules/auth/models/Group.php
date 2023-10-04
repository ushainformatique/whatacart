<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\models;

use usni\library\db\ActiveRecord;
use usni\library\modules\auth\web\IAuthIdentity;
use usni\UsniAdaptor;
use usni\library\modules\auth\business\AuthManager;
use usni\library\modules\auth\dao\AuthDAO;
/**
 * Group active record.
 * 
 * @package usni\library\modules\auth\models
 */
class Group extends ActiveRecord implements IAuthIdentity
{
    use \usni\library\traits\TreeModelTrait;
    
    /**
     * Group constants.
     */
    const ADMINISTRATORS    = 'Administrators';

    /**
     * Members of the group.
     * @var array
     */
    public $members = [];
    
    /**
     * Type of group. By default it would be system
     * @var string 
     */
    public $type = 'system';

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            $this->level = $this->getLevel();
            return true;
        }
       return false;
    }

	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'category'],        'required'],
                    ['name',        'unique', 'on' => 'create'],
                    ['name',        'unique', 'filter' => ['!=', 'id', $this->id], 'on' => 'update'],
                    ['status',      'default', 'value' => self::STATUS_ACTIVE],
                    ['parent_id',   'default', 'value' => 0],
                    ['parent_id',   'safe'],
                    [['parent_id',  'name', 'status', 'level', 'members', 'category'], 'safe'],
             ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['update']     = $scenario['create'] = ['parent_id', 'name', 'status', 'level', 'members', 'category'];
        $scenario['bulkedit']   = ['status'];
        return $scenario;
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		$labels = [
                        'parent_id'         => UsniAdaptor::t('application', 'Parent'),
                        'name'              => UsniAdaptor::t('application', 'Name'),
                        'description'       => UsniAdaptor::t('application', 'Description'),
                        'status'            => UsniAdaptor::t('application', 'Status'),
                        'members'           => UsniAdaptor::t('auth', 'Members')
                  ];
        return parent::getTranslatedAttributeLabels($labels);
	}

	/**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('auth', 'Group') : UsniAdaptor::t('auth', 'Groups');
    }

    /**
     * Gets auth name.
     * @return string
     */
    public function getAuthName()
    {
        return $this->name;
    }

    /**
     * Gets auth type.
     * @return string
     */
    public function getAuthType()
    {
        return AuthManager::TYPE_GROUP;
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if(empty($this->members))
        {
            $this->members = [];
        }
        $this->addMembers($this->members);
        $this->updateChildrensLevel();
        $this->updatePath();
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();
        $members        = array();
        $membersRecords = AuthDAO::getMembers($this->id);
        foreach($membersRecords as $member)
        {
            $members[] = $member['member_type'] . '-' . $member['member_id'];
        }
        $this->members = $members;
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            UsniAdaptor::app()->authorizationManager->deleteAssignments($this->name, 'group');
            $this->deleteMembers();
            $this->setParentAsNullForChildrenOnDelete($this->tableName());
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [ 
                    'name'     => UsniAdaptor::t('applicationhint', 'Minimum 3 characters'),
                    'members'  => UsniAdaptor::t('authhint', 'Members of the group'),
                    'parent_id'=> UsniAdaptor::t('authhint', 'Parent id for the group'),
                    'status'   => UsniAdaptor::t('authhint', 'Status for the group')
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }
    
    /**
     * Add group members.
     * @param array $members
     * @return void
     */
    public function addMembers($members)
    {
        $this->deleteMembers();
        foreach($members as $member)
        {
            $memberData = explode('-', $member);
            $groupMember              = new GroupMember(['scenario' => 'create']);
            $groupMember->member_type = $memberData[0];
            $groupMember->member_id   = $memberData[1];
            $groupMember->group_id    = $this->id;
            $groupMember->save();
        }
    }
    
    /**
     * Delete group members.
     * @return void
     */
    public function deleteMembers()
    {
        GroupMember::deleteAll('group_id = :gid', [':gid' => $this->id]);
    }
    
    /**
     * Get descendants based on a parent.
     * @param int $parentId
     * @param int $onlyChildren If only childrens have to be fetched
     * @return boolean
     */
    public function descendants($parentId = 0, $onlyChildren = false)
    {
        $recordsData    = [];
        $records        = AuthDAO::getChildrens($parentId, $this->type);
        if(!$onlyChildren)
        {
            foreach($records as $record)
            {
                $hasChildren    = false;
                $childrens      = $this->descendants($record['id'], $onlyChildren);
                if(count($childrens) > 0)
                {
                    $hasChildren = true;
                }
                $recordsData[]  = ['row'         => $record,
                                   'hasChildren' => $hasChildren, 
                                   'children'    => $childrens];
            }
            return $recordsData;
        }
        else
        {
            foreach($records as $record)
            {
                $recordsData[]  = ['row'         => $record,
                                   'hasChildren' => false, 
                                   'children'    => []];
            }
            return $recordsData;
        }
    }
    
    /**
     * inheritdoc
     * This method has been overridden to make sure that children of group would not be displayed in parent dropdown when that group would be updated.
     */
    public function getMultiLevelSelectOptions($textFieldName,
                                               $accessOwnedModelsOnly = false,
                                               $valueFieldName = 'id')
    {
        $childrens      = array_keys($this->getTreeRecordsInHierarchy());
        $itemsArray     = [];
        if($this->nodeList === null)
        {
            $this->nodeList  = $this->descendants(0, false);
        }
        $items   = static::flattenArray($this->nodeList);
        foreach($items as $item)
        {
            $row = $item['row'];
            if($this->$valueFieldName != $row[$valueFieldName])
            {
                if(($accessOwnedModelsOnly === true && $this->created_by == $row['created_by']) || ($accessOwnedModelsOnly === false))
                {
                    if(!in_array($row['id'], $childrens))
                    {
                        $itemsArray[$row[$valueFieldName]] = str_repeat('-', $row['level']) . $row[$textFieldName];
                    }
                }
            }
        }
        return $itemsArray;
    }
}