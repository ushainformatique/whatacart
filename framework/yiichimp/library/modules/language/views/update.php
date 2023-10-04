<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
/* @var $this \usni\library\components\AdminView */

use usni\UsniAdaptor;
use usni\library\widgets\BrowseDropdown;

/* @var $formDTO \usni\library\dto\FormDTO */

$model  = $formDTO->getModel();
$this->params['breadcrumbs'] = [
        [
        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
                    UsniAdaptor::t('language', 'Languages'),
        'url' => ['/language/default/index']
    ],
        [
        'label' => UsniAdaptor::t('application', 'Update') . ' #' . $model->id
    ]
];

$browseParams   = ['permission' => 'language.updateother',
                   'data'   => $formDTO->getBrowseModels(),
                   'model'  => $model];
echo BrowseDropdown::widget($browseParams);
$this->title = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('language', 'Language');
echo $this->render("/_form", ['model' => $model]);