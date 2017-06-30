<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\grid;

use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\utils\Html;
/**
 * OrderActionColumn class file.
 *
 * @package common\modules\order\grid
 */
class OrderActionColumn extends \usni\library\grid\ActionColumn
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
        if (!isset($this->buttons['paymentactivity']))
        {
            $this->buttons['paymentactivity'] = array($this, 'renderPaymentActivity');
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
            if($model['show_update_link'])
            {
                $icon = FA::icon('pencil');
                return Html::a($icon, $url, [
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
        if($this->checkAccess($model, 'view'))
        {
            $label = UsniAdaptor::t('order', 'Invoice');
            $icon  = FA::icon('bitcoin'). "\n";
            $url   = UsniAdaptor::createUrl("order/invoice/view", ['id' => $model['invoice_id']]);
            return Html::a($icon, $url, [
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
    public function renderPaymentActivity($url, $model, $key)
    {
        if($this->checkAccess($model, 'update'))
        {
            if($model['payment_activity_url'] != null)
            {
                $label = UsniAdaptor::t('order', 'Add Payment');
                $icon  = FA::icon('plus-circle'). "\n";
                $url   = UsniAdaptor::createUrl($model['payment_activity_url'], ['orderId' => $model['id']]);
                return Html::a($icon, $url, [
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
        if($this->checkAccess($model, 'view'))
        {
            $label = UsniAdaptor::t('payment', 'View Payments');
            $icon  = FA::icon('money'). "\n";
            $url   = UsniAdaptor::createUrl("order/payment/index", ['orderId' => $model['id']]);
            return Html::a($icon, $url, [
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
            $shortName  = strtolower($this->getBaseModelClassName());
            $icon       = FA::icon('eye');
            $options    = [
                            'title' => \Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'id'        => 'view-' . $shortName . '-' . $model['id'],
                            'class'     => 'view-' . $shortName
                          ];
            return Html::a($icon, $url, $options);
        }
        return null;
    }
}