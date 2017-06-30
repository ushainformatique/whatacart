<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\marketing\events;

use common\modules\marketing\models\SendMailForm;
/**
 * SendMailEvent class file.
 * 
 * @package common\modules\marketing\events
 */
class SendMailEvent extends \yii\base\Event
{
    /**
     * @var SendMailForm 
     */
    public $model;
    
    /**
     * @var string 
     */
    public $toAddress;
    
    /**
     * @var array 
     */
    public $storeOwner;
}
