<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\widgets\DetailActionToolbar;
use usni\fontawesome\FA;
use usni\library\widgets\Tabs;
use usni\library\widgets\DetailBrowseDropdown;
use products\behaviors\PriceBehavior;

/* @var $detailViewDTO \common\modules\order\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$this->attachBehavior('priceBehavior', PriceBehavior::className());
$model          = $detailViewDTO->getModel();
$this->title    = UsniAdaptor::t('application', 'View') . ' ' . UsniAdaptor::t('products', 'Order') . '  '. ' #' . $model['id'];
$this->params['breadcrumbs'] =  [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
                                        UsniAdaptor::t('order', 'Orders'),
                                        'url' => ['/order/default/index']
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('application', 'View') . ' #' . $model['id']
                                    ]
                                ];

$browseParams   = ['permission' => 'order.viewother',
                   'model' => $model,
                   'textAttribute' => 'id',
                   'data'  => $detailViewDTO->getBrowseModels(),
                   'modalDisplay' => $detailViewDTO->getModalDisplay()];

echo DetailBrowseDropdown::widget($browseParams);
$toolbarParams  = ['editUrl'            => UsniAdaptor::createUrl('order/default/update', ['id' => $model['id']]),
                   'deleteUrl'          => UsniAdaptor::createUrl('order/default/delete', ['id' => $model['id']])];
?>
<div class="panel panel-default detail-container">
    <div class="panel-heading">
        <h6 class="panel-title"><?php echo FA::icon('book') . UsniAdaptor::t('order', 'Order') . '  '. '#' . $model['id'];?></h6>
            <?php
                echo DetailActionToolbar::widget($toolbarParams);
            ?>
    </div>
    <?php
            $items[] = [
                'options' => ['id' => 'tabgeneral'],
                'label' => UsniAdaptor::t('application', 'General'),
                'class' => 'active',
                'content' => $this->render('/detail/_general', ['detailViewDTO' => $detailViewDTO])
            ];
            if($model['billingAddress'] !== false)
            {
                $items[] = [
                    'options' => ['id' => 'tabbilling'],
                    'label' => UsniAdaptor::t('customer', 'Billing Address'),
                    'content' => $this->render('/detail/_billingaddress', ['detailViewDTO' => $detailViewDTO])
                ];
            }
            if($model['shippingAddress'] !== false)
            {
                $items[] = [
                    'options' => ['id' => 'tabshipping'],
                    'label' => UsniAdaptor::t('customer', 'Shipping Address'),
                    'content' => $this->render('/detail/_shippingaddress', ['detailViewDTO' => $detailViewDTO])
                ];
            }
            $items[] = [
                'options' => ['id' => 'tabpayment'],
                'label' => UsniAdaptor::t('order', 'Payment Details'),
                'content' => $this->render('/detail/_paymentdetails', ['detailViewDTO' => $detailViewDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabproducts'],
                'label' => UsniAdaptor::t('order', 'Product Details'),
                'content' => $this->render('/detail/_productdetails', ['detailViewDTO' => $detailViewDTO])
            ];
            $items[] = [
                'options' => ['id' => 'tabhistory'],
                'label' => UsniAdaptor::t('order', 'Order History'),
                'content' => $this->render('/detail/_orderhistory', ['detailViewDTO' => $detailViewDTO])
            ];
            echo Tabs::widget(['items' => $items]);
    ?>
</div>