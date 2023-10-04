<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\grid\GridView;
use usni\library\grid\ActionToolbar;
use usni\library\modules\language\models\Language;
use yii\grid\CheckboxColumn;
use usni\library\grid\StatusDataColumn;
use usni\library\utils\StatusUtil;
use usni\library\modules\language\grid\LanguageActionColumn;

/* @var $gridViewDTO \usni\library\dto\GridViewDTO */
/* @var $this \usni\library\web\AdminView */

$title          = UsniAdaptor::t('language', 'Manage Languages');
$this->title    = $this->params['breadcrumbs'][] = $title;

$toolbarParams  = [
    'createUrl'     => 'create',
    'bulkEditFormView' => '/_bulkedit.php',
    'bulkDeleteUrl' => 'bulk-delete',
    'showBulkEdit'  => true,
    'showBulkDelete'=> true,
    'gridId'        => 'languagegridview',
    'pjaxId'        => 'languagegridview-pjax',
    'bulkEditFormTitle' => UsniAdaptor::t('language', 'Language') . ' ' . UsniAdaptor::t('application', 'Bulk Edit'),
    'bulkEditActionUrl' => 'bulk-edit',
    'bulkEditFormId'    => 'languagebulkeditview',
    'permissionPrefix'  => 'language'
];
$widgetParams   = [
                        'id'            => 'languagegridview',
                        'dataProvider'  => $gridViewDTO->getDataProvider(),
                        'filterModel'   => $gridViewDTO->getSearchModel(),
                        'caption'       => $title,
                        'modelClass'    => Language::className(),
                        'columns' => [
                                        ['class' => CheckboxColumn::className()],
                                        'name',
                                        'code',
                                        'locale',
                                        [
                                            'attribute' => 'status',
                                            'class'     => StatusDataColumn::className(),
                                            'filter'    => StatusUtil::getDropdown()
                                        ],
                                        [
                                            'class'     => LanguageActionColumn::className(),
                                            'template'  => '{view} {update} {delete}',
                                            'modelClassName' => Language::className()
                                        ]
                                     ],
                 ];
echo ActionToolbar::widget($toolbarParams);
echo GridView::widget($widgetParams);