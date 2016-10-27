<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace backend\controllers\users;

use usni\UsniAdaptor;
use usni\library\modules\users\models\User;
/**
 * Contains actions which extend the functionality related to user
 * 
 * @package backend\controllers\users
 */
class DefaultController extends \usni\library\modules\users\controllers\DefaultController
{
    /**
     * Force delete a user
     * @param string $username
     */
    public function actionForceDelete($username)
    {
        $user       = User::findByUsername($username);
        if($user != null)
        {
            $person     = $user->person;
            $address    = $user->address;
            $address->delete();
            $person->delete();
            $user->delete();
        }
        $this->redirect(UsniAdaptor::createUrl('users/default/manage'));
    }
}