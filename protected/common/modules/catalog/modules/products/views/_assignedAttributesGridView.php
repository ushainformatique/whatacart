<?php
use products\grid\AttributeActionColumn;
use products\models\ProductAttribute;
use usni\library\grid\GridView;

$widgetParams   = [
                        'id'            => 'assignattributesgridview',
                        'dataProvider'  => $dataProvider
                   ];
if(isset($layout))
{
    $widgetParams['layout'] = $layout;
}
if(isset($caption))
{
    $widgetParams['caption'] = $caption;
}
$widgetParams['columns']    = [
                                    'name',
                                    'attribute_value'
                              ];
if($showActionColumn)
{
    $widgetParams['columns'][]  =   [                           
                                        'class' => AttributeActionColumn::className(),
                                        'template' => '{update} {delete}',
                                        'modelClassName' => ProductAttribute::className()
                                    ];
}
echo GridView::widget($widgetParams);