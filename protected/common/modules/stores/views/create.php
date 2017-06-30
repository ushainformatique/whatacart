<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;

$this->params['breadcrumbs'] = [    
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('stores', 'Stores'),
                                        'url'   => ['/stores/default/index']
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('application', 'Create')
                                    ]
                               ];

$this->title = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('stores', 'Store');
echo $this->render('/_tabform', ['formDTO' => $formDTO]);