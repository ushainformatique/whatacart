<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\db;

use usni\library\db\DataManager;
use usni\library\modules\auth\models\Group;
/**
 * Loads data related to auth module.
 * 
 * @package usni\library\modules\auth\db
 */
class AuthDataManager extends DataManager
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
    public function getDefaultDataSet()
    {
        return [
                    array(  
                            'name'      => Group::ADMINISTRATORS,
                            'parent_id' => 0,
                            'level'     => 0,
                            'status'    => Group::STATUS_ACTIVE,
                            'category'  => 'system'
                        )
                ];
    }
}