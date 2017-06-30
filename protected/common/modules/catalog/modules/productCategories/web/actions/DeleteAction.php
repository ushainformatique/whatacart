<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\web\actions;

use productCategories\business\Manager;
use yii\base\InvalidParamException;
/**
 * DeleteAction class file. This would handle deleting a model.
 *
 * @package productCategories\web\actions
 */
class DeleteAction extends \usni\library\web\actions\DeleteAction
{
    /**
     * inheritdoc
     */
    public function run($id)
    {
        $isValid  = Manager::getInstance()->isValidCategory($id);
        if($isValid == false)
        {
            throw new InvalidParamException();
        }
        return parent::run($id);
    }
}