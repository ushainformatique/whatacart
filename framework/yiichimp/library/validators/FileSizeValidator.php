<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\validators;

use yii\validators\FileValidator;
/**
 * FileSizeValidator class file
 * 
 * @package usni\library\validators
 */
class FileSizeValidator extends FileValidator
{
    /**
     * @inheritdoc
    */
    public function init()
    {
        parent::init();
        $this->maxSize  = $this->getSizeLimit();
    }
}
