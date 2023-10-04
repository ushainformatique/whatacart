<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\exceptions;

use usni\UsniAdaptor;
use yii\base\Exception;
/**
 * Failed To Save Model Exception.
 * 
 * @package usni\library\exceptions
 */
class FailedToSaveModelException extends Exception
{
    /**
     * Class constructor.
     * @param string  $modelClass Model class name.
     * @param string  $message    Exception message.
     * @param integer $code       Exception code.
     */
    public function __construct($modelClass, $message=null, $code=0)
    {
        $message = UsniAdaptor::t('application', 'Failed to save model "{model}"', ['model' => $modelClass]);
        parent::__construct($message, $code);
    }
}