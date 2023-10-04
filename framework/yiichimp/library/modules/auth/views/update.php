<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;

use usni\library\modules\auth\widgets\BrowseDropdown;

/* @var $formDTO \usni\library\modules\auth\dto\FormDTO */

$model  = $formDTO->getModel();
$this->params['breadcrumbs'] = [
        [
        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
        UsniAdaptor::t('auth', 'Groups'),
        'url' => ['/auth/group/index']
    ],
        [
        'label' => UsniAdaptor::t('application', 'Update') . ' #' . $model->id
    ]
];

$browseParams   = ['permission' => 'group.updateother',
                   'data'   => $formDTO->getBrowseModels(),
                   'model'  => $model];
echo BrowseDropdown::widget($browseParams);

$this->title = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('auth', 'Group');
echo $this->render("/_form", ['formDTO' => $formDTO]);