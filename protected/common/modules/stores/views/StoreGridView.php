<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\views;

use usni\library\widgets\UiStatusDataColumn;
use usni\library\components\TranslatableGridView;
use usni\library\utils\StatusUtil;
use common\modules\stores\components\StoreNameDataColumn;
use common\modules\stores\components\StoreActionColumn;
/**
 * StoreGridView class file
 * @package common\modules\stores\views
 */
class StoreGridView extends TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                        [
                            'attribute'     => 'name',
                            'class'         => StoreNameDataColumn::className()
                        ],
                        [
                            'attribute'     => 'status',
                            'class'         => UiStatusDataColumn::className(),
                            'filter'        => StatusUtil::getDropdown()
                        ],
                        [
                            'class'         => StoreActionColumn::className(),
                            'template'      => '{view} {update} {delete} {activate} {default}'
                        ]
                   ];
        return $columns;
    }
    
    /**
     * @inheritdoc
     */
    protected static function getActionToolbarOptions()
    {
        $toolbarOptions                     = parent::getActionToolbarOptions();
        $toolbarOptions['showBulkDelete']   = false;
        return $toolbarOptions;
    }
}
?>