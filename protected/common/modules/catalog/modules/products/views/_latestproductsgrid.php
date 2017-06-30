<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use products\models\Product;
use products\grid\ProductNameDataColumn;
use usni\library\grid\StatusDataColumn;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('products', 'Latest Products');

$widgetParams   = [
                        'id'            => 'latestproductsgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'caption'       => $title,
                        'modelClass'    => Product::className(),
                        'layout'        => "<div class='panel panel-default'>
                                                <div class='panel-heading'>{caption}</div>
                                                    {items}
                                               </div>",
                        'columns'       => [
                                                [
                                                    'attribute' => 'name',
                                                    'class'     => ProductNameDataColumn::className()
                                                ],
                                                'model',
                                                [
                                                    'attribute' => 'status',
                                                    'class' => StatusDataColumn::className()
                                                ],
                                        ],
                ];
echo GridView::widget($widgetParams);