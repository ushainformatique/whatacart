<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\managers;

use productCategories\managers\ProductCategoryTableBuilder;
/**
 * TableManager class file.
 * @package productCategories\managers
 */
class TableManager extends \usni\library\components\UiTableManager
{
    /**
     * Get table builder config.
     * @return array
     */
    protected static function getTableBuilderConfig()
    {
        return [
            ProductCategoryTableBuilder::className(),
        ];
    }
}
