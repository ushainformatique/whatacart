<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views\front;

use common\modules\order\views\OrderDetailView as BaseOrderDetailView;
use common\modules\order\views\front\OrderBrowseModelView;
use common\modules\shipping\utils\ShippingUtil;
use usni\UsniAdaptor;
/**
 * OrderDetailView class file.
 * 
 * @package common\modules\order\views\front
 */
class OrderDetailView extends BaseOrderDetailView
{
    /**
     * @inheritdoc
     */
    protected function resolveColumnsToBeDisplayed()
    {
        return [
                   [
                       'attribute' => 'status', 
                       'value'     => $this->getStatusLabel(), 
                       'format'    => 'raw' 
                   ],
                   [
                       'attribute' => 'shipping', 
                       'value'     => ShippingUtil::getShippingMethodName($this->model['shipping']), 
                       'format'    => 'raw' 
                   ],
                   [
                       'label'      => UsniAdaptor::t('stores', 'Store'),
                       'attribute'  => 'store_id',
                       'value'      => $this->model['store_name']
                   ],
                   'shipping_comments'
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function renderOptions()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected static function resolveBrowseModelViewClassName()
    {
        return OrderBrowseModelView::className();
    }
}