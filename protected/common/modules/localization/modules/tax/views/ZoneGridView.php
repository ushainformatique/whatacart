<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\views;

use usni\library\components\TranslatableGridView;
use taxes\components\ZoneActionColumn;
use taxes\components\TaxNameDataColumn;
use usni\UsniAdaptor;
use taxes\utils\TaxUtil;
/**
 * ZoneGridView class file
 * @package taxes\views
 */
class ZoneGridView extends TranslatableGridView
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
                           'label'      => UsniAdaptor::t('country', 'Country'),
                           'attribute'  => 'country_id',
                           'value'     => [$this->model, 'getZoneCountry'],
                           'filter'     => TaxUtil::getCountryAndAllCountriesDropdownData()
                       ],
                       [
                           'label'      => UsniAdaptor::t('state', 'State'),
                           'attribute'  => 'state_id',
                           'value'     => [$this->model, 'getZoneState'],
                           'filter'     => TaxUtil::getStateAndAllStatesDropdownData()
                       ],
                       [
                           'class'      => ZoneActionColumn::className(),
                           'template'   => '{view} {update} {delete}'
                       ]
                   ];
        return $columns;
    }
    
    /**
     * @inheritdoc
     */
    protected static function getActionToolbarOptions()
    {
       $toolbarOptions                  = parent::getActionToolbarOptions();
       $toolbarOptions['showBulkEdit']  = false;
       return $toolbarOptions;
    }
}
?>