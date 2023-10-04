<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;

use usni\library\widgets\BrowseDropdown;

/* @var $formDTO \usni\library\modules\notification\dto\TemplateFormDTO */

$model  = $formDTO->getModel();
$this->params['breadcrumbs'] = [
        [
        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
        UsniAdaptor::t('notification', 'Templates'),
        'url' => ['/notification/template/index']
    ],
        [
        'label' => UsniAdaptor::t('application', 'Update') . ' #' . $model->id
    ]
];

$browseParams   = ['permission' => 'notificationtemplate.updateother',
                   'data'   => $formDTO->getBrowseModels(),
                   'model'  => $model,
                   'textAttribute' => 'notifykey'];
echo BrowseDropdown::widget($browseParams);

$this->title = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('notification', 'Template');
echo $this->render("/template/_form", ['formDTO' => $formDTO]);