<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views;

use usni\UsniAdaptor;
use common\modules\order\components\OrderActionColumn;
use common\modules\order\components\OrderStatusDataColumn;
use common\modules\localization\modules\orderstatus\models\OrderStatus;
use usni\library\utils\DAOUtil;
use common\modules\order\components\ShippingNameDataColumn;
use common\modules\order\utils\OrderUtil;
use products\utils\ProductUtil;
use customer\models\Customer;
use customer\utils\CustomerUtil;
use common\modules\shipping\utils\ShippingUtil;
use common\modules\payment\utils\PaymentUtil;
/**
 * OrderGridView class file.
 *
 * @package common\modules\order\views
 */
class OrderGridView extends \usni\library\components\TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                        'unique_id',
                        [
                            'label'         => UsniAdaptor::t('application', 'Name'),
                            'attribute'     => 'name'
                        ],
                        [
                            'label'         => UsniAdaptor::t('customer', 'Customer'),
                            'attribute'     => 'customer_id',
                            'value'         => [$this, 'getCustomer'],
                            'filter'        => CustomerUtil::getCustomerAndGuestDropdownData()
                        ],
                        [
                            'label'         => UsniAdaptor::t('order', 'Amount'),
                            'attribute'     => 'amount',
                            'value'         => [$this, 'getOrderAmount']
                        ],
                        [
                            'attribute'     => 'status',
                            'class'         => $this->getStatusDataColumnName(),
                            'filter'        => DAOUtil::getDropdownDataBasedOnModel(OrderStatus::className())
                        ],
                        [
                            'attribute'     => 'shipping',
                            'class'         => ShippingNameDataColumn::className(),
                            'filter'        => ShippingUtil::getMethods()
                        ],
                        [
                            'label'         => UsniAdaptor::t('payment', 'Payment Method'),
                            'attribute'     => 'payment_method',
                            'value'         => [$this, 'getPaymentMethod'],
                            'filter'        => PaymentUtil::getPaymentMethodDropdown()
                        ],
                        $this->getActionColumnConfig()
                   ];
        return $columns;
    }
    
    /**
     * Get action column config
     * @return array
     */
    protected function getActionColumnConfig()
    {
        return [
                    'class'     => OrderActionColumn::className(),
                    'template'  => '{view} {update} {delete} {invoice} {addpayment} {viewpayments}'
                ];
    }
    
    /**
     * Get status data column name
     * @return OrderStatusDataColumn
     */
    protected function getStatusDataColumnName()
    {
        return OrderStatusDataColumn::className();
    }
    
    /**
     * Get customer.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getCustomer($data, $key, $index, $column)
    {
        $customer = Customer::find()->where('id = :id', [':id' => $data['customer_id']])->asArray()->one();
        return OrderUtil::getDisplayedCustomer($customer);
    }
    
    /**
     * @inheritdoc
     */
    protected static function getActionToolbarOptions()
    {
        $options = parent::getActionToolbarOptions();
        $options['showBulkDelete']  = false;
        $options['showBulkEdit']    = false;
        return $options;
    }
    
    /**
     * Get order amount.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getOrderAmount($data, $key, $index, $column)
    {
        $price = $data['total_including_tax'] + $data['shipping_fee'];
        $price = number_format($price, 2, ".", "");
        return ProductUtil::getPriceWithSymbol($price, $data['currency_code']);
    }
    
    /**
     * Get payment method.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getPaymentMethod($data, $key, $index, $column)
    {
        return PaymentUtil::getPaymentMethodName($data['payment_method']);
    }
}
?>