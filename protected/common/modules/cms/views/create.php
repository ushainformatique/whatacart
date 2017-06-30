<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \common\modules\cms\dto\FormDTO */

use usni\UsniAdaptor;
$this->params['breadcrumbs'] = [
        [
        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
        UsniAdaptor::t('cms', 'Pages'),
        'url' => ['/cms/page/index']
    ],
        [
        'label' => UsniAdaptor::t('application', 'Create')
    ]
];
$this->title = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('cms', 'Page');
echo $this->render("/_form", ['formDTO' => $formDTO]);

