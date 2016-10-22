<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\views;

use usni\library\components\UiGridView;
use usni\library\extensions\bootstrap\widgets\UiActionColumn;
use usni\library\widgets\UiStatusDataColumn;
use usni\library\utils\StatusUtil;
/**
 * ManufacturerGridView class file.
 *
 * @package common\modules\manufacturer\views
 */
class ManufacturerGridView extends UiGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                        [
                            'attribute' => 'name',
                            'class'     => 'common\modules\manufacturer\components\ManufacturerNameDataColumn'
                        ],
                        [
                            'attribute'     => 'status',
                            'class'         => UiStatusDataColumn::className(),
                            'filter'        => StatusUtil::getDropdown()
                        ],
                        [
                            'class'     => UiActionColumn::className(),
                            'template'  => '{view} {update} {delete}'
                        ]
                   ];
        return $columns;
    }
}
?>