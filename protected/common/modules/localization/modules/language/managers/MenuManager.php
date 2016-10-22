<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\language\managers;

use common\modules\localization\modules\language\models\Language;
use usni\library\managers\BaseMenuManager;
/**
 * MenuManager class file.
 * @package common\modules\localization\modules\language\managers
 */
class MenuManager extends BaseMenuManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Language::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getModuleUniqueId()
    {
        return 'localization/language';
    }
}