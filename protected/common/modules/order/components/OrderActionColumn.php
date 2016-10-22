<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\components;

use usni\library\extensions\bootstrap\widgets\UiActionColumn;
use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\components\UiHtml;
use common\modules\order\models\Order;
use common\modules\order\utils\OrderUtil;
use common\modules\localization\modules\orderstatus\utils\OrderStatusUtil;
use usni\library\modules\auth\managers\AuthManager;
/**
 * OrderActionColumn class file.
 *
 * @package common\modules\order\components
 */
class OrderActionColumn extends UiActionColumn
{
    /**
     * Initializes the default button rendering callbacks
     */
    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();
        if (!isset($this->buttons['invoice']))
        {
            $this->buttons['invoice'] = array($this, 'renderInvoiceLink');
        }
        if (!isset($this->buttons['addpayment']))
        {
            $this->buttons['addpayment'] = array($this, 'renderAddPayment');
        }
        if (!isset($this->buttons['viewpayments']))
        {
            $this->buttons['viewpayments'] = array($this, 'renderViewPayments');
        }
    }
    
    /**
     * Renders update action link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    protected function renderUpdateActionLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'update'))
        {
            $orderStatus = OrderStatusUtil::getStatusId(Order::STATUS_COMPLETED);
            if($model['status'] != $orderStatus)
            {
                $icon = FA::icon('pencil');
                return UiHtml::a($icon, $url, [
                            'title' => \Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'id'        => 'update-order-' . $model['id'],
                            'class'     => 'update-order'
                        ]);
            }
        }
        return null;
    }
    
    /**
     * Renders invoice link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderInvoiceLink($url, $model, $key)
    {
        $user   = UsniAdaptor::app()->user->getUserModel();
        if(AuthManager::checkAccess($user, 'order.manage'))
        {
            $label = UsniAdaptor::t('order', 'Invoice');
            $icon  = FA::icon('bitcoin'). "\n";
            $url   = UsniAdaptor::createUrl("order/invoice/view", ['id' => $model['invoice_id']]);
            return UiHtml::a($icon, $url, [
                                                'title' => $label,
                                                'target' => '_blank',
                                                'data-pjax' => 0
                                          ]);
        }
        return null;
    }
    
    /**
     * Renders add payment.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderAddPayment($url, $model, $key)
    {
        $user   = UsniAdaptor::app()->user->getUserModel();
        if(AuthManager::checkAccess($user, 'order.manage'))
        {
            $paid   = OrderUtil::getAlreadyPaidAmountForOrder($model['id']);
            $total  = OrderUtil::getTotalAmount($model);
            if($total - $paid > 0)
            {
                $label = UsniAdaptor::t('order', 'Add Payment');
                $icon  = FA::icon('plus-circle'). "\n";
                $url   = UsniAdaptor::createUrl("order/payment/add", ['orderId' => $model['id']]);
                return UiHtml::a($icon, $url, [
                                                    'title' => $label
                                              ]);
            }
        }
        return null;
    }
    
    /**
     * Renders  view payments link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderViewPayments($url, $model, $key)
    {
        $user   = UsniAdaptor::app()->user->getUserModel();
        if(AuthManager::checkAccess($user, 'order.manage'))
        {
            $label = UsniAdaptor::t('payment', 'View Payments');
            $icon  = FA::icon('money'). "\n";
            $url   = UsniAdaptor::createUrl("order/payment/manage", ['orderId' => $model['id']]);
            return UiHtml::a($icon, $url, [
                                                'title' => $label
                                          ]);
        }
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderViewActionLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'view'))
        {
            $shortName  = strtolower(UsniAdaptor::getObjectClassName($this->grid->owner->model));
            $icon       = FA::icon('eye');
            $options    = [
                            'title' => \Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'id'        => 'view-' . $shortName . '-' . $model['id'],
                            'class'     => 'view-' . $shortName
                          ];
            return UiHtml::a($icon, $url, $options);
        }
        return null;
    }
}