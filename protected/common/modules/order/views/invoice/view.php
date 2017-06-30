<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

use common\modules\order\widgets\InvoiceView;
use products\behaviors\PriceBehavior;
use usni\UsniAdaptor;

/* @var $this \usni\library\web\AdminView */
$this->attachBehavior('priceBehavior', PriceBehavior::className());

$this->title = UsniAdaptor::t('order', 'View Invoice') . ' #' . $detailViewDTO->getModel()['unique_id'];
/* @var $detailViewDTO \common\modules\order\dto\InvoiceDetailViewDTO */
/* @var $this \usni\library\web\AdminView */
echo InvoiceView::widget(['invoice' => $detailViewDTO->getModel(), 'orderProducts' => $detailViewDTO->getOrderProducts()]);