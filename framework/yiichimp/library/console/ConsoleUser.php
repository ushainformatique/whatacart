<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\console;

use usni\library\modules\users\models\User;

/**
 * Extends functionality for user identity for console application.
 * 
 * @package usni\library\console
 */
class ConsoleUser extends \yii\web\User
{
    /**
     * inheritdoc
     */
	public function getIdentity($autoRenew = true)
	{
        return User::findOne(User::SUPER_USER_ID);
	}
}