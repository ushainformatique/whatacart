<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\widgets\DetailView;
use usni\library\widgets\DetailBrowseDropdown;
use taxes\utils\TaxUtil;

/* @var $detailViewDTO \usni\library\dto\DetailViewDTO */
/* @var $this \usni\library\web\AdminView */

$model          = $detailViewDTO->getModel();
$this->title    = UsniAdaptor::t('application', 'View') . ' ' . UsniAdaptor::t('tax', 'Tax Rule') . ' #' . $model['id'];
$this->params['breadcrumbs'] =  [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
                                        UsniAdaptor::t('tax', 'Tax Rules'),
                                        'url' => ['/localization/tax/rule/index']
                                    ],
                                    [
                                        'label' => $this->title
                                    ]
                                ];
$editUrl        = UsniAdaptor::createUrl('localization/tax/rule/update', ['id' => $model['id']]);
$deleteUrl      = UsniAdaptor::createUrl('localization/tax/rule/delete', ['id' => $model['id']]);
$browseParams   = ['permission' => 'taxrule.viewother',
                   'model' => $model,
                   'modalDisplay' => $detailViewDTO->getModalDisplay(),
                   'data'  => $detailViewDTO->getBrowseModels()];
$toolbarParams  = ['editUrl'   => $editUrl,
                   'deleteUrl' => $deleteUrl];
$widgetParams   = [
                    'detailViewDTO' => $detailViewDTO,
                    'caption'       => $model['name'],
                    'attributes'    => [
                                            'name',
                                            [
                                                'attribute' => 'based_on', 
                                                'value'     => TaxUtil::getBasedOnDisplayValue($model['based_on'])
                                            ],
                                            [
                                                'label'     => UsniAdaptor::t('customer', 'Customer Groups'),
                                                'attribute' => 'customer_groups'
                                            ],
                                            [
                                                'label'     => UsniAdaptor::t('tax', 'Product Tax Classes'),
                                                'attribute' => 'product_tax_classes'
                                            ],
                                            'type',
                                            'value',
                                            [
                                                'label'     => UsniAdaptor::t('tax', 'Zones'),
                                                'attribute' => 'tax_zones',
                                            ],
                                            [
                                                'attribute' => 'created_by',
                                                'value'     => $this->getAuthorName($detailViewDTO->getCreatedBy())
                                            ],
                                            [
                                                'attribute' => 'created_datetime',
                                                'value'     => $this->getFormattedDateTime($model['created_datetime'])
                                            ],
                                            [
                                                'attribute' => 'modified_by',
                                                'value'     => $this->getAuthorName($detailViewDTO->getModifiedBy())
                                            ],
                                            [
                                                'attribute' => 'modified_datetime',
                                                'value'     => $this->getFormattedDateTime($model['modified_datetime'])
                                            ]
                                       ],
                    
                    'actionToolbar' => $toolbarParams
                 ];
echo DetailBrowseDropdown::widget($browseParams);
echo DetailView::widget($widgetParams);
