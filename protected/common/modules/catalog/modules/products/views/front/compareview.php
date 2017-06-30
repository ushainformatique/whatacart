<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use products\models\CompareProducts;
use products\grid\front\CompareActionColumn;
use products\grid\front\RatingDataColumn;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \frontend\web\View */
$this->title = UsniAdaptor::t('products', 'Compare Products');
?>
<h2><?php echo $this->title;?></h2>
<?php
$this->params['breadcrumbs'] = [
                                    ['label' => UsniAdaptor::t('customer', 'My Account'), 'url' => UsniAdaptor::createUrl('customer/site/my-account')],
                                    ['label' => $this->title]
                                ];

$widgetParams   = [
                        'id'            => 'comparegridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'caption'       => $this->title,
                        'layout'        => "{items}\n{summary}",
                        'tableOptions'  => ['class' => "table table-striped"],
                        'columns' => [
                            [
                                'attribute' => 'image',
                                'value'     => 'displayImage',
                                'format'    => 'raw',
                                'filter'    => false,
                                'enableSorting' => false
                            ],
                            'name',
                            'model',
                            'description',
                            [
                                'attribute' => 'manufacturer',
                                'value'     => 'manufacturerName'
                            ],
                            [
                                'attribute' => 'weight',
                                'value'     => 'convertedWeight',
                            ],
                            [
                                'label'     => UsniAdaptor::t('products', 'Availability'),
                                'value'     => 'availability',
                            ],
                            [
                                'label'     => UsniAdaptor::t('products', 'Dimensions(L*W*H)'),
                                'value'     => 'dimensions',
                            ],
                            [
                                'attribute' => 'price',
                                'value'     => 'formattedPrice'
                            ],
                            [
                                'label'     => UsniAdaptor::t('products', 'Attributes'),
                                'value'     => 'attributes',
                                'format'    => 'html'
                            ],
                            [
                                'label'     => UsniAdaptor::t('products', 'Rating'),
                                'class'     => RatingDataColumn::className()
                            ],
                            [
                                'class' => CompareActionColumn::className(),
                                'template' => '{addToCart} {remove}',
                                'modelClassName' => CompareProducts::className()
                            ]
                        ],
                ];
?>
<div class="compare-grid-container">
    <?php
        echo GridView::widget($widgetParams);
    ?>
</div>