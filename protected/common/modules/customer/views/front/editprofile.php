<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;

$title              = UsniAdaptor::t('users', 'Edit Profile');
$this->title        = $title;
$this->leftnavView  = '/front/_sidebar'; 
$this->params['breadcrumbs'] = [    
                                    [
                                        'label' => UsniAdaptor::t('customer', 'My Account'),
                                        'url'   => ['/customer/site/my-account']
                                    ],
                                    [
                                        'label' => $title
                                    ]
                               ];
echo $this->render('/front/_tabform', ['formDTO' => $formDTO]);