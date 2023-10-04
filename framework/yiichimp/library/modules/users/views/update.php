<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */

/* @var $form \usni\library\bootstrap\TabbedActiveForm */
/* @var $this \usni\library\web\AdminView */
/* @var $userFormDTO \usni\library\modules\users\dto\UserFormDTO */
/* @var $formDTO \usni\library\modules\users\dto\UserFormDTO */

use usni\UsniAdaptor;
use usni\library\modules\users\widgets\BrowseDropdown;

$user = $formDTO->getModel();
$this->params['breadcrumbs'] = [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('users', 'Users'),
                                        'url'   => ['/users/default/index']
                                    ],
                                    [
                                        'label' => UsniAdaptor::t('application', 'Update') . ' #' . $user['id']
                                    ]
                               ];
$browseParams   = ['permission' => 'user.updateother',
                   'data' => $formDTO->getBrowseModels(),
                   'model' => $user,
                   'textAttribute' => 'username'];
echo BrowseDropdown::widget($browseParams);
$this->title = UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('users', 'User');
echo $this->render('/_tabform', ['formDTO' => $formDTO]);