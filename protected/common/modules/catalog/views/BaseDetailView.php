<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\catalog\views;

use usni\library\views\UiDetailView;
use usni\UsniAdaptor;
/**
 * BaseDetailView class file
 * @package products\views
 */
class BaseDetailView extends UiDetailView
{
    /**
     * Gets delete button url.
     *
     * @return string
     */
    protected function getDeleteUrl()
    {
        return UsniAdaptor::createUrl('/catalog/' . $this->getModule() . '/' . $this->controller->id . '/delete', ['id' => $this->model->id]);
    }

    /**
     * Gets edit button url.
     *
     * @return string
     */
    protected function getEditUrl()
    {
        return UsniAdaptor::createUrl('/catalog/' . $this->getModule() . '/' . $this->controller->id . '/update', ['id' => $this->model->id]);
    }
    
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return parent::getColumns();
    }
}
?>