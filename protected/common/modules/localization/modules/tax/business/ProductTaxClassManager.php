<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\business;

use usni\library\business\Manager;
use taxes\dao\ProductTaxClassDAO;
use yii\base\InvalidParamException;
/**
 * ProductTaxClassManager class file.
 * 
 * @package taxes\business
 */
class ProductTaxClassManager extends Manager
{
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return ProductTaxClassDAO::getAll($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model  = ProductTaxClassDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Id is not valid: $id");
        }
        return $model;
    }
}
