<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\currency\managers;

use common\modules\localization\modules\currency\models\Currency;
use usni\library\managers\BaseMenuManager;
/**
 * MenuManager class file.
 * @package common\modules\localization\modules\currency\managers
 */
class MenuManager extends BaseMenuManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Currency::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getModuleUniqueId()
    {
        return 'localization/currency';
    }
}