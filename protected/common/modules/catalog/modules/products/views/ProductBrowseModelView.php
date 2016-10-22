<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use usni\library\views\UiBrowseModelView;
use usni\library\utils\ArrayUtil;
use products\utils\ProductUtil;

/**
 * ProductBrowseModelView class file.
 *
 * @package products\views
 */
class ProductBrowseModelView extends UiBrowseModelView
{
    /**
     * Resolve dropdown data.
     * @return array
     */
    protected function resolveDropdownData()
    {
        $records            = ProductUtil::getStoreProducts();
        $filteredModels     = [];
        foreach($records as $value)
        {
            if($this->shouldRenderOwnerCreatedModelsForBrowse)
            {
                if($value['id'] != $this->model->id && $value['created_by'] == $this->model->created_by)
                {
                    $filteredModels[] = $value;
                }
            }
            else
            {
                if($value['id'] != $this->model->id)
                {
                    $filteredModels[] = $value;
                }
            }
        }
        return ArrayUtil::map($filteredModels, 'id', $this->attribute);
    }
}
?>