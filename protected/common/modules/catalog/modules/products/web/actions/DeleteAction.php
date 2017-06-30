<?php

/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\web\actions;

use products\business\Manager;
use yii\base\InvalidParamException;
/**
 * DeleteAction class file.
 *
 * @package products\web\actions.
 */
class DeleteAction extends \usni\library\web\actions\DeleteAction
{
    /**
     * inheritdoc
     */
    public function run($id)
    {
        $isValid  = Manager::getInstance()->isValidProductId($id);
        if($isValid == false)
        {
            throw new InvalidParamException();
        }
        return parent::run($id);
    }
}
