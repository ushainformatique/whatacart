<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\stockstatus\managers;

use common\modules\localization\modules\stockstatus\models\StockStatus;
use usni\library\managers\BaseMenuManager;
/**
 * MenuManager class file.
 * @package common\modules\localization\modules\stockstatus\managers
 */
class MenuManager extends BaseMenuManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return StockStatus::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getModuleUniqueId()
    {
        return 'localization/stockstatus';
    }
}