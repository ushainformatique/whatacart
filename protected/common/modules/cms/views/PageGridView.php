<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\views;

use usni\library\components\TranslatableGridView;
use common\modules\cms\components\StatusDataColumn;
use common\modules\cms\utils\DropdownUtil;
use usni\library\extensions\bootstrap\widgets\UiActionColumn;
use common\modules\cms\components\CmsNameDataColumn;
/**
 * PageGridView class file
 * 
 * @package common\modules\cms\views
 */
class PageGridView extends TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                      [
                          'attribute'   => 'name',  
                          'class'       => CmsNameDataColumn::className()
                      ],
                      [
                          'attribute'   => 'status',
                          'class'       => StatusDataColumn::className(),
                          'filter'      => DropdownUtil::getStatusSelectOptions()
                      ],
                      [
                          'attribute'   => 'parent_id',
                          'value'       => [$this->model, 'getParentName'],
                          'filter'      => $this->model->getParentFilterDropdown()
                      ],
                      [
                          'class'       => UiActionColumn::className(),
                          'template'    => '{view} {update} {delete}'
                      ]  
                   ];
        return $columns;
    }
}