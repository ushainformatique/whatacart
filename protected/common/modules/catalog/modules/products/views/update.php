<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

/* @var $form \usni\library\bootstrap\TabbedActiveForm */
/* @var $this \usni\library\web\AdminView */

use usni\UsniAdaptor;
use usni\library\widgets\BrowseDropdown;

/* @var $formDTO \products\dto\FormDTO */

$model = $formDTO->getModel();
$this->params['breadcrumbs'] = [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('products', 'Products'),
                                        'url'   => ['/catalog/products/default/index']
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('application', 'Update') . ' #' . $model['id']
                                    ]
                               ];
$browseParams   = ['permission' => 'product.updateother',
                   'data' => $formDTO->getBrowseModels(),
                   'model' => $model];
echo BrowseDropdown::widget($browseParams);
$this->title = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('products', 'Product');
echo $this->render('/_tabform', ['formDTO' => $formDTO]);