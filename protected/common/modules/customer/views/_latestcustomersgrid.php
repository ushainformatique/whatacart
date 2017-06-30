<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use customer\models\Customer;
use customer\widgets\CustomerNameDataColumn;
use usni\library\grid\StatusDataColumn;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('customer', 'Latest Customers');

$widgetParams   = [
                        'id'            => 'latestcustomersgridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'caption'       => $title,
                        'modelClass'    => Customer::className(),
                        'layout'        => "<div class='panel panel-default'>
                                                <div class='panel-heading'>{caption}</div>
                                                    {items}
                                               </div>",
                        'columns'       => [
                                                [
                                                    'attribute' => 'username',
                                                    'class'     => CustomerNameDataColumn::className()
                                                ],
                                                'email',
                                                [
                                                    'attribute' => 'status',
                                                    'class' => StatusDataColumn::className()
                                                ],
                                        ],
                ];
echo GridView::widget($widgetParams);