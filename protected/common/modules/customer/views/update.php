<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

/* @var $form \usni\library\bootstrap\TabbedActiveForm */
/* @var $this \usni\library\web\AdminView */
/* @var $userFormDTO \usni\library\modules\users\dto\UserFormDTO */

use usni\UsniAdaptor;
use usni\library\modules\users\widgets\BrowseDropdown;

$customer = $formDTO->getModel();
$this->params['breadcrumbs'] = [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('customer', 'Customers'),
                                        'url'   => ['/customer/default/index']
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('application', 'Update') . ' #' . $customer['id']
                                    ]
                               ];
$browseParams   = ['permission' => 'customer.updateother',
                   'data' => $formDTO->getBrowseModels(),
                   'model' => $customer,
                   'textAttribute' => 'username'];
echo BrowseDropdown::widget($browseParams);
$this->title = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('customer', 'Customer');
echo $this->render('/_tabform', ['formDTO' => $formDTO]);