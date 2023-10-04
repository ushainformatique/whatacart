<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\events;

use usni\library\modules\users\models\User;
/**
 * Implements the functionality when change password event is raised
 *
 * @package usni\library\modules\users\events
 */
class ChangePasswordEvent extends \yii\base\Event
{
    /**
     * User for which password is changed
     * @var User 
     */
    public $user;
}
