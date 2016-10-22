<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * ManufacturerTableBuilder class file.
 * @package common\modules\manufacturer\managers
 */
class ManufacturerTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'image' => Schema::TYPE_STRING . '(64) NULL',
            'status' => Schema::TYPE_SMALLINT . '(1)',
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_name', 'name', false]
               ];
    }
}