<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\views;

use usni\library\components\TranslatableGridView;
use taxes\components\StateActionColumn;
use common\modules\localization\components\LocalizationNameDataColumn;
use usni\library\utils\DAOUtil;
use common\modules\localization\modules\country\models\Country;
use usni\library\widgets\UiStatusDataColumn;
use usni\library\utils\StatusUtil;
/**
 * StateGridView class file
 * 
 * @package common\modules\localization\modules\state\views
 */
class StateGridView extends TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return array(
                       [
                            'attribute'     => 'country_id',
                            'value'         => 'country.name',
                            'filter'        => DAOUtil::getDropdownDataBasedOnModel(Country::className())
                       ],
                       [
                            'attribute'     => 'name',
                            'class'         => LocalizationNameDataColumn::className(),
                        ],
                       'code',
                       [
                            'attribute'     => 'status',
                            'class'         => UiStatusDataColumn::className(),
                            'filter'        => StatusUtil::getDropdown()
                        ],
                        [
                            'class'         => StateActionColumn::className(),
                            'template'      => '{view} {update} {delete}'
                        ]
        );
    }
}