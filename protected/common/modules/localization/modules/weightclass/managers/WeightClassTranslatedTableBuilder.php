<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\weightclass\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * WeightClassTranslatedTableBuilder class file.
 * @package common\modules\localization\modules\weightclass\managers
 */
class WeightClassTranslatedTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'owner_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'language' => Schema::TYPE_STRING . '(10) NOT NULL',
            'name' => Schema::TYPE_STRING . '(128)',
        ];
    }
}
?>
