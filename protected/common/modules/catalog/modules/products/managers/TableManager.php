<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\managers;

/**
 * TableManager class file.
 *
 * @package products\managers
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
                    ProductTableBuilder::className(),
                    ProductAttributeTableBuilder::className(),
                    ProductCategoryMappingTableBuilder::className(),
                    ProductOptionTableBuilder::className(),
                    ProductOptionValueTableBuilder::className(),
                    ProductAttributeGroupTableBuilder::className(),
                    ProductRelatedProductMappingTableBuilder::className(),
                    ProductTagMappingTableBuilder::className(),
                    ProductReviewTableBuilder::className(),
                    ProductAttributeMappingTableBuilder::className(),
                    ProductOptionMappingTableBuilder::className(),
                    ProductOptionMappingDetailsTableBuilder::className(),
                    ProductDiscountTableBuilder::className(),
                    ProductSpecialTableBuilder::className(),
                    TagTableBuilder::className(),
                    ProductImageTableBuilder::className(),
                    ProductRatingTableBuilder::className()
            ];
    }
}
