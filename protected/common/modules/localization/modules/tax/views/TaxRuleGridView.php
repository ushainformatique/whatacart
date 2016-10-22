<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\views;

use usni\library\components\TranslatableGridView;
use usni\library\extensions\bootstrap\widgets\UiActionColumn;
use usni\UsniAdaptor;
use customer\utils\CustomerUtil;
use taxes\utils\TaxUtil;
/**
 * TaxRuleGridView class file
 * @package taxes\views
 */
class TaxRuleGridView extends TranslatableGridView
{

    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                        'name',
                        ['attribute' => 'based_on', 
                         'value'    => [$this, 'getBasedOnDisplayValue'],
                         'filter'   => TaxUtil::getBasedOnDropdown()
                        ],
                        [
                            'label'     => UsniAdaptor::t('customer', 'Customer Groups'),
                            'attribute' => 'customerGroups',
                            'value'     => [$this->model, 'getCustomerGroup'],
                            'filter'    => CustomerUtil::getCustomerGroupDropdownData()
                        ],
                        [
                            'class'         => UiActionColumn::className(),
                            'template'      => '{view} {update} {delete}'
                        ]
                   ];
        return $columns;
    }
    
    /**
     * Gets based on display value.
     * @param mixed $model the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public static function getBasedOnDisplayValue($model, $key, $index, $column)
    {
        $value = TaxUtil::getBasedOnDisplayValue($model->based_on);
        if(!empty($value))
        {
            return $value;
        }
        return UsniAdaptor::t('application', '(not set)');
    }
}
?>