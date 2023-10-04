<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;

$this->params['breadcrumbs'] = [    
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('users', 'Users'),
                                        'url'   => ['/users/default/index']
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('application', 'Create')
                                    ]
                               ];

$this->title = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('users', 'User');
echo $this->render('/_tabform', ['formDTO' => $formDTO]);