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

/* @var $formDTO \common\modules\stores\dto\FormDTO */
$store = $formDTO->getModel()->store;
$this->params['breadcrumbs'] = [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('stores', 'Stores'),
                                        'url'   => ['/stores/default/index']
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('application', 'Update') . ' #' . $store['id']
                                    ]
                               ];
$browseParams   = ['permission' => 'users.updateother',
                   'data' => $formDTO->getBrowseModels(),
                   'model' => $store];
echo BrowseDropdown::widget($browseParams);
$this->title = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('stores', 'Store');
echo $this->render('/_tabform', ['formDTO' => $formDTO]);