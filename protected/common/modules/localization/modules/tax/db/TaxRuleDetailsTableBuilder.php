<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\db;

use usni\library\db\TableBuilder;
/**
 * TaxRuleDetailsTableBuilder class file.
 * 
 * @package taxes\db
 */
class TaxRuleDetailsTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(),
            'tax_rule_id' => $this->integer(11)->notNull(),
            'product_tax_class_id' => $this->integer(11)->notNull(),
            'customer_group_id' => $this->integer(11)->notNull(),
            'tax_zone_id' => $this->integer(11)->notNull()
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_product_tax_class_id', 'product_tax_class_id', false],
                    ['idx_customer_group_id', 'customer_group_id', false],
                    ['idx_tax_rule_id', 'tax_rule_id', false],
                    ['idx_tax_zone_id', 'tax_zone_id', false]
               ];
    }
}