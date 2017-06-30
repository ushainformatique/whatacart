<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \taxes\dto\ZoneFormDTO */

use usni\UsniAdaptor;
$this->params['breadcrumbs'] = [
        [
        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
        UsniAdaptor::t('tax', 'Zones'),
        'url' => ['/localization/tax/zone/index']
    ],
        [
        'label' => UsniAdaptor::t('application', 'Create')
    ]
];
$this->title = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('tax', 'Zone');
echo $this->render("/zone/_form", ['formDTO' => $formDTO]);

