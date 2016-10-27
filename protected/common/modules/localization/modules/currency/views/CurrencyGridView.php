<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\views;

use usni\library\components\TranslatableGridView;
use usni\library\widgets\UiStatusDataColumn;
use usni\library\utils\StatusUtil;
use common\modules\localization\modules\currency\components\CurrencyActionColumn;
/**
 * CurrencyGridView class file
 *
 * @package common\modules\localization\modules\currency\views
 */
class CurrencyGridView extends TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                        'name',
                        'code',
                        'value',
                        [
                            'attribute' => 'status',
                            'class'     => UiStatusDataColumn::className(),
                            'filter'    => StatusUtil::getDropdown()
                        ],
                        [
                            'class'     => CurrencyActionColumn::className(),
                        ]
                   ];
        return $columns;
    }
}