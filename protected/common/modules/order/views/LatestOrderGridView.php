<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views;

use usni\library\components\UiGridView;
use usni\UsniAdaptor;
use usni\library\modules\auth\managers\AuthManager;
use yii\data\ActiveDataProvider;
use common\modules\order\components\OrderStatusDataColumn;
use usni\library\modules\users\models\Address;
use products\utils\ProductUtil;
use common\modules\order\utils\OrderUtil;
/**
 * LatestOrderGridView class file.
 *
 * @package common\modules\order\views
 */
class LatestOrderGridView extends UiGridView
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
                            'label'         => UsniAdaptor::t('order', 'Amount'),
                            'attribute'     => 'amount',
                            'value'         => [$this, 'getOrderAmount']
                        ],
                        [
                            'attribute'     => 'status',
                            'class'         => $this->getStatusDataColumnName(),
                        ]
                   ];
        return $columns;
    }
    
    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return UsniAdaptor::t('order', 'Latest Orders');
    }
    
    /**
     * @inheritdoc
     */
    protected function getDataProvider()
    {
        $user           = UsniAdaptor::app()->user->getUserModel();
        $currentStore   = UsniAdaptor::app()->storeManager->getCurrentStore();
        $tableName           = UsniAdaptor::tablePrefix() . 'order';
        $orderAddressDetails = UsniAdaptor::tablePrefix() . 'order_address_details';
        $orderPaymentDetails = UsniAdaptor::tablePrefix() . 'order_payment_details';
        $orderInvoice       = UsniAdaptor::tablePrefix() . 'invoice';
        $customerTable      = UsniAdaptor::tablePrefix() . 'customer';
        //$paymentTable       = UsniAdaptor::tablePrefix() . 'payment';
        $query          = (new \yii\db\Query());
        $query->select(["ot.*", "opd.payment_method", "opd.total_including_tax", "opd.shipping_fee", "oi.id AS invoice_id", "CONCAT_WS(' ', oad.firstname, oad.lastname) AS name"])
              ->from(["$tableName ot"])
              ->innerJoin("$orderAddressDetails oad", "ot.id = oad.order_id AND oad.type = :type", [':type' => Address::TYPE_BILLING_ADDRESS])
              ->innerJoin("$orderPaymentDetails opd", "ot.id = opd.order_id")
              ->innerJoin("$orderInvoice oi", "ot.id = oi.order_id")
              ->leftJoin("$customerTable tc", "ot.customer_id = tc.id")
              ->where('ot.store_id = :sid', [':sid' => $currentStore->id])
              ->orderBy('ot.id DESC');
        if(!(AuthManager::isUserInAdministrativeGroup($user)
                    && AuthManager::isSuperUser($user)) && !AuthManager::checkAccess($user, 'user.viewother'))
        {
            $query->andFilterWhere(['ot.created_by' => $user->id]);
        }
        $query->limit(5);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $dataProvider->setPagination(false);
        return $dataProvider;
    }

    /**
     * @inheritdoc
     */
    protected function renderToolbar()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderCheckboxColumn()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected function getLayout()
    {
        return "<div class='panel panel-default'><div class='panel-heading'>{caption}</div>\n{items}</div>";
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
     * Get order amount.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getOrderAmount($data, $key, $index, $column)
    {
        $price = OrderUtil::getTotalAmount($data);
        $price = number_format($price, 2, ".", "");
        return ProductUtil::getPriceWithSymbol($price, $data['currency_code']);
    }
}