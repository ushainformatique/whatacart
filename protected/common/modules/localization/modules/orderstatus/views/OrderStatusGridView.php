<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\views;

use usni\library\components\TranslatableGridView;
use common\modules\localization\modules\orderstatus\components\OrderStatusActionColumn;
/**
 * OrderStatusGridView class file
 * 
 * @package common\modules\localization\modules\orderstatus\views
 */
class OrderStatusGridView extends TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                        'name',
                        [
                            'class'         => OrderStatusActionColumn::className(),
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
        $options                    = parent::getActionToolbarOptions();
        $options['showBulkEdit']    = false;
        return $options;
    }
}