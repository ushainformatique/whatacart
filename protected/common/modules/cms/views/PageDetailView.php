<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\views;

use usni\library\views\UiDetailView;
use common\modules\cms\utils\DropdownUtil;
use common\modules\cms\models\Page;
/**
 * PageDetailView class file
 * @package common\modules\cms\views
 */
class PageDetailView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                    'name',
                    ['attribute'        => 'menuitem',    'value'   => $this->model->menuitem],
                    ['attribute'        => 'parent_id', 'value' => Page::getParentName($this->model, null, null, null)],
                    'alias',
                    [
                        'attribute'     => 'content', 
                        'format'        => 'raw', 
                        'value'         => $this->model->content],
                    [
                        'attribute'     => 'status',
                        'value'         => DropdownUtil::renderLabel($this->model),
                        'format'        => 'html'
                    ]
               ];
    }

    /**
     * Gets created by user.
     * @return string
     */
    protected function getCreatedBy()
    {
        $id = $this->model->created_by;
        $data = User::findOne($id);
        return $data->username;
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