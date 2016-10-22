<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use common\modules\catalog\views\BaseDetailView;
use products\utils\ProductUtil;
/**
 * ProductAttributeDetailView class file
 *
 * @package products\views
 */
class ProductAttributeDetailView extends BaseDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                 'name',
                 'sort_order',
                 [
                     'attribute'    => 'attribute_group',
                     'value'        => ProductUtil::getAttributeGroup($this->model->attribute_group)
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