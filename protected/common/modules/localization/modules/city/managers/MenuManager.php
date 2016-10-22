<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\city\managers;

use common\modules\localization\modules\city\models\City;
use usni\library\managers\BaseMenuManager;
/**
 * MenuManager class file.
 * @package common\modules\localization\modules\city\managers
 */
class MenuManager extends BaseMenuManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return City::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getModuleUniqueId()
    {
        return 'localization/city';
    }
}