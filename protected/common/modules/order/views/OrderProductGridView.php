<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\views;

use usni\UsniAdaptor;
use usni\library\extensions\bootstrap\widgets\UiActionColumn;
use usni\library\components\UiGridView;
use common\modules\order\models\OrderProduct;
/**
 * OrderProductGridView class file
 * @package common\modules\order\views
 */
class OrderProductGridView extends UiGridView
{
    /**
     * Product id
     * @var int
     */
    public $productId;
    
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                       [
                           'attribute'  => 'product_id',
                           'value'      => [$this, 'getProductName']
                       ],
                       'model',
                       'quantity',
                       [
                           'label'      => UsniAdaptor::t('products', 'Unit Price'),
                           'attribute'  => 'price'
                       ],
//                       [
//                           'attribute'  => 'total'
//                       ],
                       [
                           'class'      => UiActionColumn::className(),
                           'template'   => '{view} {update} {delete}'
                       ]
                   ];
        return $columns;
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
    protected function resolveDataProviderQuery()
    {
        return OrderProduct::find()->where('product_id = :pid', [':pid' => $this->productId]);
    }
    
    /**
     * @inheritdoc
     */
    public function renderTitle()
    {
        return null;
        //return UsniAdaptor::t('application', 'Manage') . ' ' . OrderProduct::getLabel(2);
    }
    
    /**
     * Gets Product name.
     * @param mixed $model the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getProductName($model, $key, $index, $column)
    {
        $orderProduct = OrderProduct::find()->where('product_id = :pId', [':pId' => $this->productId])->one();
        if(!empty($orderProduct))
        {
            return $orderProduct->name;
        }
        return null;
    }
}
?>