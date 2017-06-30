<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\db;

use usni\library\modules\auth\models\Group;
/**
 * Loads data related to auth module.
 * 
 * @package common\db
 */
class AuthDataManager extends \usni\library\modules\auth\db\AuthDataManager
{
    /**
     * @inheritdoc
     */
    public function getDefaultDemoDataSet()
    {
        return [
                    [ 
                        'name'      => 'General',
                        'parent_id' => 0,
                        'level'     => 0,
                        'status'    => Group::STATUS_ACTIVE,
                        'category'  => 'customer'
                    ],
                    [ 
                        'name'      => 'Wholesale',
                        'parent_id' => 0,
                        'level'     => 0,
                        'status'    => Group::STATUS_ACTIVE,
                        'category'  => 'customer'
                    ],
                    [
                        'name'      => 'Retailer',
                        'parent_id' => 0,
                        'level'     => 0,
                        'status'    => Group::STATUS_ACTIVE,
                        'category'  => 'customer'
                    ]
        ];
    }
}