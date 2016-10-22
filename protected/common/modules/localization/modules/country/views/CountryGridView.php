<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\views;

use usni\library\components\TranslatableGridView;
use usni\library\extensions\bootstrap\widgets\UiActionColumn;
use common\modules\localization\components\LocalizationNameDataColumn;
use usni\library\widgets\UiStatusDataColumn;
use usni\library\utils\StatusUtil;
/**
 * CountryGridView class file
 * @package common\modules\localization\modules\country\views
 */
class CountryGridView extends TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                        [
                            'attribute'     => 'name',
                            'class'         => LocalizationNameDataColumn::className()
                        ],
                            'iso_code_2',
                            'iso_code_3',
                        [
                            'attribute'     => 'status',
                            'class'         => UiStatusDataColumn::className(),
                            'filter'        => StatusUtil::getDropdown(),
                        ],
                        [
                            'class'         => UiActionColumn::className(),
                            'template'      => '{view} {update} {delete}'
                        ]
                   ];
        return $columns;
    }
}
?>