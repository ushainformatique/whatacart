<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\dataCategories\views;

use usni\library\views\UiDetailView;
use usni\library\utils\StatusUtil;

/**
 * DataCategoryDetailView class file
 * @package common\modules\dataCategories\views
 */
class DataCategoryDetailView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                'name',
                ['attribute' => 'description', 'format' => 'html'],
                ['attribute' => 'status', 'value'  => StatusUtil::renderLabel($this->model), 'format' => 'raw'],
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return $this->model->name;
    }
}
?>