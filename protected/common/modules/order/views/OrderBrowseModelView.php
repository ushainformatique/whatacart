<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\views;

use common\modules\order\utils\OrderUtil;
use usni\library\utils\ArrayUtil;
/**
 * Browse model view for order
 * @package common\modules\order\views;
 */
class OrderBrowseModelView extends \usni\library\views\UiBrowseModelView
{
    /**
     * @inheritdoc
     */
    protected function resolveDropdownData()
    {
        $records            = OrderUtil::getStoreOrders();
        $filteredModels     = [];
        foreach($records as $value)
        {
            if($this->shouldRenderOwnerCreatedModelsForBrowse)
            {
                if($value['id'] != $this->model['id'] && $value['created_by'] == $this->model['created_by'])
                {
                    $filteredModels[] = $value;
                }
            }
            else
            {
                if($value['id'] != $this->model['id'])
                {
                    $filteredModels[] = $value;
                }
            }
        }
        return ArrayUtil::map($filteredModels, 'id', 'id');
    }
}
