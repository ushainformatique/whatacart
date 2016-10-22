<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\city\views;

use usni\library\components\TranslatableGridView;
use usni\library\extensions\bootstrap\widgets\UiActionColumn;
use common\modules\localization\components\LocalizationNameDataColumn;
use usni\library\utils\DAOUtil;
use common\modules\localization\modules\country\models\Country;
/**
 * CityGridView class file
 * @package common\modules\localization\modules\city\views
 */
class CityGridView extends TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
            [
                'attribute'     => 'name',
                'class'         => LocalizationNameDataColumn::className(),
            ],
            [
                'attribute'    => 'country_id',
                'value'        => 'country.name',
                'filter'       => DAOUtil::getDropdownDataBasedOnModel(Country::className())
            ],
            [
                'class'         => UiActionColumn::className(),
                'template'      => '{view} {update} {delete}'
            ]
        ];
        return $columns;
    }
    
    /**
     * @inheritdoc
     */
    protected static function getActionToolbarOptions()
    {
        $option                 = parent::getActionToolbarOptions();
        $option['showBulkEdit'] = false;
        return $option;
    }
}
?>