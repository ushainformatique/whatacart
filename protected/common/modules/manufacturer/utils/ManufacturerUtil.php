<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\manufacturer\utils;

use usni\UsniAdaptor;
use common\modules\manufacturer\models\Manufacturer;

/**
 * ManufacturerUtil class file.
 *
 * @package common\modules\manufacturer\utils
 */
class ManufacturerUtil
{
    /**
     * Get manufacturer by id
     * @param int $manId
     * @return array
     */
    public static function getManufacturer($manId)
    {
        $manTable           = Manufacturer::tableName();
        $sql                = "SELECT * FROM $manTable WHERE id = :id";
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':id' => $manId])->queryOne();
    }
}