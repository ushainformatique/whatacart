<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;

/* @var $formDTO \newsletter\dto\FormDTO */

$model  = $formDTO->getModel();
$this->params['breadcrumbs'] = [
        [
        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
        UsniAdaptor::t('newsletter', 'Newsletters'),
        'url' => ['/marketing/newsletter/default/index']
    ],
        [
        'label' => UsniAdaptor::t('application', 'Update') . ' #' . $model->id
    ]
];

$this->title = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('newsletter', 'Newsletter');
echo $this->render("/_form", ['formDTO' => $formDTO]);