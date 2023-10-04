<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \usni\library\modules\auth\dto\FormDTO */

use usni\UsniAdaptor;
$this->params['breadcrumbs'] = [
        [
        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
        UsniAdaptor::t('notification', 'Layouts'),
        'url' => ['/notification/layout/index']
    ],
        [
        'label' => UsniAdaptor::t('application', 'Create')
    ]
];
$this->title = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('notification', 'Layout');
echo $this->render("/layout/_form", ['formDTO' => $formDTO]);

