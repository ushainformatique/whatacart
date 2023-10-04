<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\traits;

use usni\library\db\ActiveRecord;
use usni\library\modules\users\models\User;
use usni\UsniAdaptor;
/**
 * Common methods used for the active records in the application.
 * 
 * @package usni\library\traits
 */
trait ActiveRecordTrait
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(ActiveRecord::EVENT_BEFORE_INSERT, [$this, 'updateCreatedFields']);
        $this->on(ActiveRecord::EVENT_BEFORE_INSERT, [$this, 'updateModifiedFields']);
        $this->on(ActiveRecord::EVENT_BEFORE_UPDATE, [$this, 'updateModifiedFields']);
    }
    
    /**
     * Update user and datetime field by attribute
     * @param string $scenario
     */
    public function updateFields($scenario)
    {
        if($scenario == 'create')
        {
            $this->updateAuthorField('created_by');
            $this->updateAuthorField('modified_by');
            $this->updateDateTimeField('created_datetime');
            $this->updateDateTimeField('modified_datetime');
        }
        else
        {
            $this->updateAuthorField('modified_by');
            $this->updateDateTimeField('modified_datetime');
        }
        
    }
    
    /**
     * Update author field
     * @param string $userField
     */
    public function updateAuthorField($userField)
    {
        if(!$this->hasAttribute($userField))
        {
            return;
        }
        $isInstalled    = UsniAdaptor::app()->installed;
        $userModel      = UsniAdaptor::app()->user->getIdentity();
        if(!$isInstalled)
        {
           $this->$userField = User::SUPER_USER_ID;
        }
        else
        {
            if($userModel != null)
            {
                $this->$userField = $userModel['id'];
            }
            else
            {
                $this->$userField = 0;
            }
        }
    }
    
    /**
     * Update datetime field
     * @param string $timeField
     */
    public function updateDateTimeField($timeField)
    {
        if(!$this->hasAttribute($timeField))
        {
            return;
        }
        $this->$timeField = date('Y-m-d H:i:s');
    }

    /**
     * Updates active record date time fields if exists.
     * @param \yii\db\ModelEvent $event
     */
    public function updateModifiedFields($event)
    {
        if($this->shouldAddCreatedAndModifiedFields())
        {
            $this->updateFields('update');
        }
    }
    
    /**
     * Updates active record date time fields if exists.
     * @param \yii\db\ModelEvent $event
     */
    public function updateCreatedFields($event)
    {
        if($this->shouldAddCreatedAndModifiedFields())
        {
            $this->updateFields('create');
        }
    }
}