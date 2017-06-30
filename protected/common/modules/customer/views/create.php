<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;

$this->params['breadcrumbs'] = [    
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('customer', 'Customers'),
                                        'url'   => ['/customer/default/index']
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('application', 'Create')
                                    ]
                               ];

$this->title = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('customer', 'Customer');
echo $this->render('/_tabform', ['formDTO' => $formDTO]);