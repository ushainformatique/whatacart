<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views;

use usni\library\components\UiGridView;
use usni\UsniAdaptor;
use products\utils\ProductUtil;
use usni\library\extensions\bootstrap\widgets\UiActionColumn;
use usni\library\utils\DateTimeUtil;
use usni\library\components\UiHtml;
use usni\library\utils\ArrayUtil;
use common\modules\payment\utils\PaymentUtil;
use common\modules\order\components\OrderPaymentsActionToolBar;
/**
 * OrderPaymentsGridView class file.
 *
 * @package common\modules\order\views
 */
class OrderPaymentsGridView extends UiGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $filterParams       = UsniAdaptor::app()->request->get($this->getFilterModelClass());
        $createdDatetime    = ArrayUtil::getValue($filterParams, 'created_datetime');
        $columns = [
                        [
                            'label'     => UsniAdaptor::t('order', 'Order Id'),
                            'attribute' => 'unique_id'
                        ],
                        [
                            'attribute' => 'amount',
                            'value' => [$this, 'getFormattedPrice']
                        ],
                        [
                            'attribute' => 'payment_method',
                            'value' => [$this, 'getPaymentMethodName'],
                            'filter'    => PaymentUtil::getPaymentMethodDropdown()
                        ],
                        [
                            'attribute' => 'created_datetime',
                            'value'     => [$this, 'getFormattedTime'],
                            'filter'    => UiHtml::textInput(UiHtml::getInputName($this->filterModel, 'created_datetime'), $createdDatetime, $this->getDateFilterOptions())
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
                    'class'     => UiActionColumn::className(),
                    'template'  => '{delete}'
                ];
    }
    
    /**
     * @inheritdoc
     */
    protected static function getActionToolbarOptions()
    {
        return ['showBulkEdit'            => false,
                'showBulkDelete'          => true,
                'showCreate'              => false,
                'showSettings'            => true];
    }
    
    /**
     * Gets formatted price.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getFormattedPrice($data, $key, $index, $column)
    {
        return ProductUtil::getPriceWithSymbol($data['amount'], $data['currency_code']);
    }
    
    /**
     * Gets payment method name.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getPaymentMethodName($data, $key, $index, $column)
    {
        return PaymentUtil::getPaymentMethodName($data['payment_method']);
    }
    
    /**
     * @inheritdoc
     */
    public function renderTitle()
    {
        return UsniAdaptor::t('payment', 'Manage Payments');
    }
    
    /**
     * Gets formatted time.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getFormattedTime($data, $key, $index, $column)
    {
        return DateTimeUtil::getFormattedDateTime($data['created_datetime']);
    }
    
    /**
     * Get date filter options.
     * @return array
     */
    protected function getDateFilterOptions()
    {
        return ['class' => 'form-control', 'id' => null, 'placeholder' => 'YYYY-MM-DD H:i:s'];
    }
    
    /**
     * @inheritdoc
     */
    public static function getGridViewActionToolBarClassName()
    {
        return OrderPaymentsActionToolBar::className();
    }
}
