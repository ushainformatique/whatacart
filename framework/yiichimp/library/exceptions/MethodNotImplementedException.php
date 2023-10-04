<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\exceptions;

use usni\UsniAdaptor;
/**
 * Method Not Implemented Exception.
 * @package usni\library\exceptions
 */
class MethodNotImplementedException extends \yii\base\UserException
{
    /**
     * Class constructor.
     *
     * @param string  $methodName Method name.
     * @param string  $className Class Name
     */
    public function __construct($methodName, $className)
    {
        $message = UsniAdaptor::t('application', 'Method "{method}" is not implemented for class "{class}"',
                                                        ['method' => $methodName, 'class' => $className]);
        parent::__construct($message);
    }
}
?>