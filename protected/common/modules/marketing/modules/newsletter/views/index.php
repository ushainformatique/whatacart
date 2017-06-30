<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use newsletter\grid\ActionToolbar;
use yii\grid\CheckboxColumn;
use usni\library\grid\ActionColumn;
use newsletter\models\Newsletter;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('products', 'Manage Newsletters');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'showBulkEdit'  => false,
    'showBulkDelete'=> false,
    'gridId'        => 'newslettergridview',
    'pjaxId'        => 'newslettergridview-pjax',
    'permissionPrefix'  => 'newsletter'
];
$widgetParams   = [
                        'id'            => 'newslettergridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => Newsletter::className(),
                        'columns' => [
                            ['class' => CheckboxColumn::className()],
                            'subject',
                            [
                                'attribute' => 'content',
                                'format'    => 'raw',
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'template' => '{view} {update} {delete}',
                                'modelClassName' => Newsletter::className()
                            ]
                        ],
                ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);
$error  = UsniAdaptor::t('application', 'Please select at least one record.');
$url    =  UsniAdaptor::createUrl('/marketing/newsletter/default/send');
$this->registerJs("$('.send-newsletter-btn').on('click', function(e){
                            var idList = $('#newslettergridview').yiiGridView('getSelectedRows');
                            if(idList == '')
                            {
                                alert('{$error}');
                                return false;
                            }
                            var url = '{$url}' + '?selectedIds=' + idList;
                            window.location.href = url;
                       })");