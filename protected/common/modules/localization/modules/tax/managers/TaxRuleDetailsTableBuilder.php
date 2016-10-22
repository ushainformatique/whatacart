<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * TaxRuleDetailsTableBuilder class file.
 * @package taxes\managers
 */
class TaxRuleDetailsTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'tax_rule_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'product_tax_class_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'customer_group_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'tax_rate_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'tax_zone_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_tax_rate_id', 'tax_rate_id', false],
                    ['idx_product_tax_class_id', 'product_tax_class_id', false],
                    ['idx_customer_group_id', 'customer_group_id', false],
                    ['idx_tax_rule_id', 'tax_rule_id', false],
                    ['idx_tax_zone_id', 'tax_zone_id', false],
               ];
    }
}