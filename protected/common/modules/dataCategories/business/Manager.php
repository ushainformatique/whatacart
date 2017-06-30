<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\dataCategories\business;

use common\modules\dataCategories\dao\DataCategoryDAO;
use common\modules\dataCategories\models\DataCategory;
use yii\base\InvalidParamException;
/**
 * Manager class file.
 *
 * @package common\modules\dataCategories\business;
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return DataCategoryDAO::getAll($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model      = DataCategoryDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Object not found: $id");
        }
        return $model;
    }
}
