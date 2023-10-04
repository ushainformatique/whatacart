<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\dto;

/**
 * BaseDTO implements common functions related to data transfer object
 *
 * @package usni\library\dto
 */
class BaseDTO extends \yii\base\BaseObject
{
    /**
     * Implement __toString magic method
     * @return string
     */
    public function __toString()
    {
        return serialize($this);
    }
}
