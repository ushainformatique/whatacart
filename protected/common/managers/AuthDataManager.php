<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\managers;

use usni\library\components\UiDataManager;
use usni\library\modules\auth\models\Group;
use customer\utils\CustomerUtil;
use usni\UsniAdaptor;
/**
 * Loads data related to auth module.
 * 
 * @package common\managers
 */
class AuthDataManager extends UiDataManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Group::className();
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
        return [
                    [ 
                        'name'      => Group::getAdminGroupTitle(),
                        'parent_id' => 0,
                        'level'     => 0,
                        'status'    => Group::STATUS_ACTIVE
                    ],
                    [
                        'name'      => CustomerUtil::getDefaultGroupTitle(),
                        'parent_id' => 0,
                        'level'     => 0,
                        'status'    => Group::STATUS_ACTIVE
                    ]
                ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getDefaultDemoDataSet()
    {
        $customerGroup = Group::findByName(CustomerUtil::getDefaultGroupTitle());
        return [
            [ 
                'name'      => UsniAdaptor::t('customer', 'Default'),
                'parent_id' => $customerGroup->id,
                'level'     => 1,
                'status'    => Group::STATUS_ACTIVE
            ],
            [ 
                'name'      => UsniAdaptor::t('customer', 'Wholesale'),
                'parent_id' => $customerGroup->id,
                'level'     => 1,
                'status'    => Group::STATUS_ACTIVE
            ],
            [
                'name'      => UsniAdaptor::t('customer', 'Retailer'),
                'parent_id' => $customerGroup->id,
                'level'     => 1,
                'status'    => Group::STATUS_ACTIVE
            ]
        ];
    }
}