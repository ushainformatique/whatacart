<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\views;

use usni\library\components\TranslatableGridView;
use taxes\components\TaxRateActionColumn;
use taxes\components\TaxNameDataColumn;
use usni\library\utils\DAOUtil;
use taxes\models\Zone;
use taxes\utils\TaxUtil;
/**
 * TaxRateGridView class file
 * @package taxes\views
 */
class TaxRateGridView extends TranslatableGridView
{

    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                       [
                           'attribute'  => 'name',
                           'class'      => TaxNameDataColumn::className()
                       ],
                       [
                           'attribute'  => 'type',
                           'filter'     => TaxUtil::getTaxTypeDropdown()
                       ],
                       [
                           'attribute'  => 'tax_zone_id',
                           'value'      => [$this->model, 'getTaxZone'],
                           'filter'     => DAOUtil::getDropdownDataBasedOnModel(Zone::className())
                       ],
                       [
                           'class'      => TaxRateActionColumn::className(),
                           'template'   => '{view} {update} {delete}'
                       ]
                   ];
        return $columns;
    }
}
?>