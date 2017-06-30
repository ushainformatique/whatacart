<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;

use usni\library\widgets\BrowseDropdown;

/* @var $formDTO \usni\library\dto\FormDTO */

$model  = $formDTO->getModel();
$this->params['breadcrumbs'] = [
        [
        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
        UsniAdaptor::t('orderstatus', 'Order Status'),
        'url' => ['/localization/orderstatus/default/index']
    ],
        [
        'label' => UsniAdaptor::t('application', 'Update') . ' #' . $model->id
    ]
];

$browseParams   = ['permission' => 'orderstatus.updateother',
                   'data'   => $formDTO->getBrowseModels(),
                   'model'  => $model];
echo BrowseDropdown::widget($browseParams);

$this->title = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('orderstatus', 'Order Status');
echo $this->render("/_form", ['formDTO' => $formDTO]);
