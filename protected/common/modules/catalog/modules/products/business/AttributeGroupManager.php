<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\business;

use products\dao\AttributeGroupDAO;
use yii\base\InvalidParamException;
/**
 * AttributeGroupManager class file.
 *
 * @package products\business
 */
class AttributeGroupManager extends \usni\library\business\Manager
{    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return AttributeGroupDAO::getAll($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model      = AttributeGroupDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Object not found: $id");
        }
        return $model;
    }
    
    /**
     * inheritdoc
     */
    public function getPermissionPrefix($modelClass)
    {
        return 'product';
    }
}