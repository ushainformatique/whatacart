<?php
namespace common\modules\order\views;

use usni\library\components\UiGridView;
use products\utils\ProductUtil;
use common\modules\order\components\InvoiceActionColumn;
/**
 * InvoiceGridView class file.
 * @package common\modules\order\views
 */
class InvoiceGridView extends UiGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                        'unique_id',
                        'order_id',
                        [
                            'attribute' => 'price_excluding_tax',
                            'value'     => [$this, 'getFormattedPrice']
                        ],
                        [
                            'attribute' => 'tax',
                            'value'     => [$this, 'getFormattedTax']
                        ],
                        'total_items',
                        'shipping_fee',
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
                    'class'     => InvoiceActionColumn::className(),
                    'template'  => '{view} {update} {delete} {print} {download}'
                ];
    }
    
    /**
     * @inheritdoc
     */
    protected static function getActionToolbarOptions()
    {
        $options = parent::getActionToolbarOptions();
        $options['showBulkEdit']  = false;
        $options['showCreate']    = false;
        return $options;
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
        return ProductUtil::getFormattedPrice($data->price_excluding_tax);
    }
    
    /**
     * Gets formatted tax.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getFormattedTax($data, $key, $index, $column)
    {
        return ProductUtil::getFormattedPrice($data->tax);
    }
}
?>