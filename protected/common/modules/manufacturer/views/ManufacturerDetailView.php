<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\views;

use usni\library\views\UiDetailView;
use usni\library\utils\FileUploadUtil;
use usni\library\utils\StatusUtil;
/**
 * ManufacturerDetailView class file.
 *
 * @package common\modules\manufacturer\views
 */
class ManufacturerDetailView extends UiDetailView
{

    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                   'name',
                   [
                       'attribute'  => 'image', 
                       'value'      => FileUploadUtil::getThumbnailImage($this->model, 'image'),
                       'format'     => 'raw'
                   ],
                   [
                       'attribute' => 'status',
                       'value'     => StatusUtil::renderLabel($this->model),
                       'format'    => 'raw'
                   ]
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