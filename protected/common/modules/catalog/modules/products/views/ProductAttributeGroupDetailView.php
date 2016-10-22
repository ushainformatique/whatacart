<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use common\modules\catalog\views\BaseDetailView;
/**
 * ProductAttributeGroupDetailView class file
 * @package products\views
 */
class ProductAttributeGroupDetailView extends BaseDetailView
{

    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                 'name',
                 'sort_order'
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