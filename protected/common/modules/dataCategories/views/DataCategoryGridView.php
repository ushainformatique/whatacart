<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\dataCategories\views;

use usni\library\widgets\UiStatusDataColumn;
use usni\library\utils\StatusUtil;
use usni\library\components\TranslatableGridView;
use common\modules\dataCategories\components\DataCategoryActionColumn;

/**
 * DataCategoryGridView class file
 * 
 * @package common\modules\dataCategories\views
 */
class DataCategoryGridView extends TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                    'name',
                    [
                     'attribute'    => 'status',
                     'class'        => UiStatusDataColumn::className(),
                     'filter'       => StatusUtil::getDropdown()
                    ],
                    [
                        'class'     => DataCategoryActionColumn::className(),
                    ]
                ];
    }
}