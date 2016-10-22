<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace taxes\utils;

use usni\library\utils\PermissionUtil;
use taxes\models\ProductTaxClass;
use taxes\models\TaxRate;
use taxes\models\TaxRule;
use taxes\models\Zone;


/**
 * TaxPermissionUtil class file.
 * @package taxes\utils;
 */
class TaxPermissionUtil extends PermissionUtil
{
    /**
     * Gets models associated to the tax module.
     * @return array
     */
    public static function getModels()
    {
        return [
                    ProductTaxClass::className(),
                    TaxRate::className(),
                    TaxRule::className(),
                    Zone::className(),
               ];
    }

    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'tax';
    }
}
?>