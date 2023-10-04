<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\events;

use usni\library\modules\users\models\User;
/**
 * Create user event class.
 *
 * @package usni\library\modules\users\events
 */
class CreateUserEvent extends \yii\base\Event
{
    /**
     * User model.
     * @var User 
     */
    public $user;
}
