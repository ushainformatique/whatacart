<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * StateTableBuilder class file.
 * @package common\modules\localization\modules\state\managers
 */
class StateTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'country_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'status' => Schema::TYPE_SMALLINT . '(1) NOT NULL',
            'code' => Schema::TYPE_STRING . '(10) NOT NULL',
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
            ['idx_status', 'status', false],
            ['idx_country', 'country_id', false],
            ['idx_code', 'code', false],
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected static function isTranslatable()
    {
        return true;
    }
}
?>