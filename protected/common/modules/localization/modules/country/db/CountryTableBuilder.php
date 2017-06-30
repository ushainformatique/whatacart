<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\db;

use usni\library\db\TableBuilder;
/**
 * TableBuilder class file.
 * 
 * @package common\modules\localization\modules\country\db
 */
class CountryTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(),
            'postcode_required' => $this->smallInteger(1),
            'status' => $this->smallInteger(1),
            'iso_code_2' => $this->string(2),
            'iso_code_3' => $this->string(3),
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