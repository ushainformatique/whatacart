<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

/* @var $this \usni\library\web\AdminView */
/* @var $formDTO \taxes\dto\TaxRuleFormDTO */

use usni\UsniAdaptor;
$this->params['breadcrumbs'] = [
        [
        'label' => UsniAdaptor::t('application', 'Manage') . ' ' .
        UsniAdaptor::t('tax', 'Tax Rules'),
        'url' => ['/localization/tax/rule/index']
    ],
        [
        'label' => UsniAdaptor::t('application', 'Create')
    ]
];
$this->title = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('tax', 'Tax Rule');
echo $this->render("/taxrule/_form", ['formDTO' => $formDTO]);

