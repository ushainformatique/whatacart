<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * TableBuilder class file.
 * @package common\modules\localization\modules\country\managers
 */
class CountryTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'postcode_required' => Schema::TYPE_SMALLINT . '(1) NOT NULL',
            'status' => Schema::TYPE_SMALLINT . '(1) NOT NULL',
            'iso_code_2' => Schema::TYPE_STRING . '(11)',
            'iso_code_3' => Schema::TYPE_STRING . '(11)',
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
