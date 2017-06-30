<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\lengthclass\business;

use common\modules\localization\modules\lengthclass\dao\LengthClassDAO;
use yii\base\InvalidParamException;
/**
 * Manager class file.
 *
 * @package common\modules\localization\modules\lengthclass\business
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return LengthClassDAO::getAll($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model      = LengthClassDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Id is not valid: $id");
        }
        return $model;
    }
}