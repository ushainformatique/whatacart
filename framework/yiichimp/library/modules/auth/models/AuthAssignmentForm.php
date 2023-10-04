<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\models;

use usni\UsniAdaptor;
/**
 * AuthAssignmentForm class file.
 * 
 * @package usni\library\modules\auth\models
 */
class AuthAssignmentForm extends \yii\base\Model
{
    /**
     * Permissions in the system.
     * @var array
     */
    public $permissions;
    /**
     * Auth identity id.
     * @var int
     */
    public $identityId;
    /**
     * Auth identity type.
     * @var string
     */
    public $type;
    /**
     * Associated auth permissions for the auth identity.
     * @var array
     */
    public $assignments;
    /**
     * Auth Identity Object
     * @var Object
     */
    public $identity;

    /**
     * @inheritdoc
     */
    public function __construct($identityId, $type)
    {
        $this->identityId   = $identityId;
        $this->type         = $type;
        $this->permissions      = UsniAdaptor::app()->authorizationManager->getAllPermissionsList();
        if($this->identityId != null && $this->type != null)
        {
            $this->identity     = UsniAdaptor::app()->authorizationManager->getIdentity($this->identityId, $this->type);
            $this->assignments  = UsniAdaptor::app()->authorizationManager->getAssignedPermissions($this->identity->getAuthName(),
                                                                                  $this->identity->getAuthType());
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['identityId', 'type'],                    'required'],
                    [['identityId', 'type', 'permissions', 'assignments'],     'safe'],
                    ['identityId',                                  'number'],
                    ['type',                                        'string'],
               ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'permissions' => UsniAdaptor::t('auth', 'Permissions'),
               ];
    }

    /**
     * Get attribute hints.
     * @return array
     */
    public function attributeHints()
    {
        return array();
    }
}