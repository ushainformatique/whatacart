<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views;

use usni\library\views\UiDetailView;
use products\utils\ProductUtil;
use usni\UsniAdaptor;
/**
 * InvoiceDetailView class file.
 * @package common\modules\order\views
 */
class InvoiceDetailView extends UiDetailView
{

    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                   'unique_id',
                   'order_id',
                   [
                       'attribute' => 'price_excluding_tax',
                       'value'     => ProductUtil::getFormattedPrice($this->model->price_excluding_tax)
                   ],
                   [
                       'attribute' => 'tax',
                       'value'     => ProductUtil::getFormattedPrice($this->model->tax)
                   ],
                   'total_items',
                   'shipping_fee',
                   [
                       'attribute'      => 'terms',
                       'format'         => 'raw'
                   ],
               ];
    }

    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return UsniAdaptor::t('order', 'Invoice View') . ' #'. $this->model->id;
    }
}
?>