<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\business;

use yii\base\InvalidParamException;
use products\dao\ProductAttributeDAO;
use products\dao\AttributeGroupDAO;
use usni\library\utils\ArrayUtil;
use products\dto\AssignAttributeDTO;
use products\models\ProductAttributeMapping;
use products\business\Manager as ProductBusinessManager;
/**
 * ProductAttributeManager class file.
 *
 * @package products\business
 */
class ProductAttributeManager extends \common\business\Manager
{    
    /**
     * inheritdoc
     */
    public function processEdit($formDTO)
    {
        parent::processEdit($formDTO);
        $attributeGroups = $this->getAttributeGroups();
        $formDTO->setAttributeGroupData($attributeGroups);
    }
    
    /**
     * inheritdoc
     */
    public function processList($gridViewDTO)
    {
        parent::processList($gridViewDTO);
        $attributeGroups = $this->getAttributeGroups();
        $gridViewDTO->setAttributeGroupData($attributeGroups);
    }
    
    /**
     * Get product attribute groups.
     * @return array
     */
    private function getAttributeGroups()
    {
        $attributes = AttributeGroupDAO::getAll($this->language);
        return ArrayUtil::map($attributes, 'id', 'name');
    }
    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return ProductAttributeDAO::getAll($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model      = ProductAttributeDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Object not found: $id");
        }
        $attributeGroup          = AttributeGroupDAO::getById($model['attribute_group'], $this->language);
        $model['attributeGroup'] = $attributeGroup['name'];
        return $model;
    }
    
    /**
     * Process assign attributes
     * @param int $productId
     * @param AssignAttributeDTO $attributeDTO
     */
    public function processAssignAttributes($productId, $attributeDTO)
    {
        $model              = new ProductAttributeMapping();
        $model->product_id  = $productId;
        $attributeDTO->setModel($model);
        $attributes         = ArrayUtil::map(ProductAttributeDAO::getAll($this->language), 'id', 'name');
        $attributeDTO->setAttributes($attributes);
        $dataProvider       = ProductBusinessManager::getInstance(['language' => $this->language])->getAssignedAttributesDataProvider($productId);
        $attributeDTO->setAttributesDataProvider($dataProvider);
    }
    
    /**
     * Process save of assign attributes
     * @param array $postData
     */
    public function processSaveAttributeAssignment($postData)
    {
        $productId      = $postData['product_id'];
        $attributeId    = $postData['attribute_id'];
        $productAttributeMapping        = ProductAttributeMapping::getMapping($productId, $attributeId);
        if($productAttributeMapping == null)
        {
            $productAttributeMapping = new ProductAttributeMapping();
        }
        $productAttributeMapping->attributes   = $postData;   
        $productAttributeMapping->save();
    }
    
    /**
     * Process edit assign attributes
     * @param int $productId
     * @param int $attributeId
     * @param AssignAttributeDTO $attributeDTO
     */
    public function processEditAssignAttributes($productId, $attributeId, $attributeDTO)
    {
        $model              = ProductAttributeMapping::getMapping($productId, $attributeId);
        $attributeDTO->setModel($model);
        $attributes         = ArrayUtil::map(ProductAttributeDAO::getAll($this->language), 'id', 'name');
        $attributeDTO->setAttributes($attributes);
        $dataProvider       = ProductBusinessManager::getInstance(['language' => $this->language])->getAssignedAttributesDataProvider($productId);
        $attributeDTO->setAttributesDataProvider($dataProvider);
    }
    
    /**
     * inheritdoc
     */
    public function getPermissionPrefix($modelClass)
    {
        return 'product';
    }
}