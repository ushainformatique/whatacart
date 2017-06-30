<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;

/* @var $formDTO \products\dto\FormDTO */

$this->params['breadcrumbs'] = [    
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('products', 'Product Downloads'),
                                        'url'   => ['/catalog/products/download/index']
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('application', 'Create')
                                    ]
                               ];

$this->title = UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('products', 'Product Download');
echo $this->render('/productdownloads/_form', ['formDTO' => $formDTO]);