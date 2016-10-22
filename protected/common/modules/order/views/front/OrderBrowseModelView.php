<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views\front;

use common\modules\order\views\OrderBrowseModelView as BaseBrowseModelView;
use usni\library\utils\ArrayUtil;
use common\modules\order\utils\OrderUtil;
use usni\UsniAdaptor;
/**
 * Browse model view for order
 *
 * @package common\modules\order\views;
 */
class OrderBrowseModelView extends BaseBrowseModelView
{
    /**
     * @inheritdoc
     */
    protected function resolveDropdownData()
    {
        $cid = UsniAdaptor::app()->user->getUserModel()->id;
        return ArrayUtil::map(OrderUtil::getStoreOrdersForCustomer($cid), 'id', 'unique_id');
    }
}
