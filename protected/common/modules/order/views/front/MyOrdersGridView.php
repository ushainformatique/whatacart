<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views\front;

use usni\library\components\UiGridView;
use usni\UsniAdaptor;
use common\modules\order\components\OrderStatusDataColumn;
use common\modules\localization\modules\orderstatus\models\OrderStatus;
use usni\library\utils\DAOUtil;
use common\modules\order\components\MyOrderActionColumn;
use usni\library\utils\DateTimeUtil;
use products\utils\ProductUtil;
use usni\library\utils\ArrayUtil;
use usni\library\components\UiHtml;
/**
 * MyOrdersGridView class file.
 *
 * @package common\modules\order\views
 */
class MyOrdersGridView extends UiGridView
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
                            'label'         => UsniAdaptor::t('order', 'Order ID'),
                            'attribute'     => 'unique_id'
                        ],
                        [
                            'attribute'     => 'status',
                            'class'         => OrderStatusDataColumn::className(),
                            'filter'        => DAOUtil::getDropdownDataBasedOnModel(OrderStatus::className())
                        ],
                        [
                            'label'     => UsniAdaptor::t('products', 'Amount'),
                            'attribute' => 'amount',
                            'value'     => [$this, 'getOrderAmount'],
                        ],
                        [
                            'label'     => UsniAdaptor::t('order', 'Date Added'),
                            'attribute' => 'created_datetime',
                            'value'     => [$this, 'getFormattedDate'],
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
                    'class'     => MyOrderActionColumn::className(),
                    'template'  => '{view}'
                ];
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
    public function renderTitle()
    {
        return UsniAdaptor::t('order', 'My Orders');
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
        if($this->layout == null)
        {
            return "<div class='panel panel-default'>"
                        . "<div class='panel-heading'>{caption}</div>"
                        . "<div class='panel-body'>"
                            . "<div class='datatable-scroll'>{items}</div>"
                            . "<div class='datatable-footer'>{summary}{pager}</div>"
                        . "</div>"
                    . "</div>";
        }
        return $this->layout;
    }
    
    /**
     * @inheritdoc
     */
    protected function resolvePageSize($metadata)
    {
        return 5;
    }
    
    /**
     * Get formatted date.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getFormattedDate($data, $key, $index, $column)
    {
        return DateTimeUtil::getFormattedDate($data['created_datetime']);
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
     * @inheritdoc
     */
    protected function getTableOptions()
    {
        return ['class' => 'table'];
    }
    
    /**
     * Get date filter options.
     * @return array
     */
    protected function getDateFilterOptions()
    {
        return ['class' => 'form-control', 'id' => null, 'placeholder' => 'YYYY-MM-DD H:i:s'];
    }
}
?>