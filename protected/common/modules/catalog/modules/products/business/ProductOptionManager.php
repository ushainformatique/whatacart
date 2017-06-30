<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\business;

use products\models\ProductOptionValue;
use usni\library\utils\ArrayUtil;
use usni\UsniAdaptor;
use products\dao\ProductOptionDAO;
use yii\base\InvalidParamException;
use products\models\ProductOptionMapping;
use products\dto\AssignOptionDTO;
use products\dao\ProductDAO;
use products\business\Manager as ProductBusinessManager;
use products\models\ProductOptionMappingDetails;
use products\models\ProductOption;
/**
 * ProductOptionManager class file.
 *
 * @package products\business
 */
class ProductOptionManager extends \common\business\Manager
{    
    /**
     * inheritdoc
     */
    public function afterModelSave($model)
    {
        parent::afterModelSave($model);
        $optionValuePostData = ArrayUtil::getValue($_POST, 'ProductOptionValue', null);
        return $this->saveOptionValues($model, $optionValuePostData);
    }
    
    /**
     * Save product option values.
     * 
     * The post data would be in format
     * [
     *       ['value' => 'L', 'id' => -1],
     *       ['value' => 'M', 'id' => -1],
     *       ['value' => 'XL', 'id' => -1],
     *       ['value' => 'S', 'id' => -1]
     *   ]
     * @param ProductOption $model
     * @param array $postData
     * @return boolean
     */
    public function saveOptionValues($model, $postData)
    {
        if($postData != null)
        {
            $inputOptionValuesKeys  = $this->getInputOptionKeys($postData);
            $optionValuesModels     = $model->optionValues;
            $unsetValues            = [];
            $setValues              = [];
            //Unset the values which are removed from the screen using - option
            if(!empty($optionValuesModels))
            {
                foreach($optionValuesModels as $optionValueModel)
                {
                    if(!in_array($optionValueModel['id'], $inputOptionValuesKeys))
                    {
                        $unsetValues[] = $optionValueModel['id'];
                    }
                    else
                    {
                        $setValues[$optionValueModel['id']] = $optionValueModel;
                    }
                }
            }
            //Set the value which are sent in input
            foreach($postData as $key => $valueArray)
            {
                if(ArrayUtil::getValue($setValues, $valueArray['id']) != null)
                {
                    $inputValue           = $setValues[$valueArray['id']];
                    $inputValue->value    = $valueArray['value'];
                    $inputValue->save();
                }
                elseif($valueArray['value'] != null)
                {
                    $optionValueModel            = new ProductOptionValue(['scenario' => 'create']);
                    $optionValueModel->option_id = $model->id;
                    $optionValueModel->value     = $valueArray['value'];
                    $this->beforeModelSave($optionValueModel);
                    if($optionValueModel->save())
                    {
                        if(!$optionValueModel->saveTranslatedModels())
                        {
                            return false;
                        }
                    }
                }
            }
            if(!empty($unsetValues))
            {
                //Delete the values from db if not in input
                $tableName      = UsniAdaptor::tablePrefix() . 'product_option_value';
                UsniAdaptor::app()->db->createCommand()->delete($tableName, ['in', 'id', $unsetValues])->execute();
            }
        }
        else
        {
            foreach($model->optionValues as $optionValueModel)
            {
                $optionValueModel->delete();
            }
        }
        return true;
    }
    
    /**
     * Get input option keys
     * @param array $postData
     * @return array
     */
    public function getInputOptionKeys($postData)
    {
        $keys = [];
        foreach($postData as $key => $valueArray)
        {
            if($valueArray['id'] != '-1')
            {
                $keys[] = $valueArray['id'];
            }
        }
        return $keys;
    }
    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return ProductOptionDAO::getAll($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model      = ProductOptionDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Object not found: $id");
        }
        $model['option_values'] = $this->getOptionValues($model['id']);
        return $model;
    }
    
    /**
     * Get product option values.
     * @param integer $id
     * @return string
     */
    public function getOptionValues($id)
    {
        $optionValues = ProductOptionDAO::getOptionValues($id, $this->language);
        if(!empty($optionValues))
        {
            $values       = [];
            foreach ($optionValues as $optionValue)
            {
                $values[] = $optionValue['value'];
            }
            return implode(', ', $values);
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * Process assign options
     * @param int $productId
     * @param AssignOptionDTO $optionDTO
     */
    public function processAssignOptions($productId, $optionDTO)
    {
        $model              = new ProductOptionMapping();
        $model->product_id  = $productId;
        $optionDTO->setModel($model);
        $options            = ArrayUtil::map(ProductOptionDAO::getAll($this->language), 'id', 'name');
        $optionDTO->setOptions($options);
        $product            = ProductDAO::getById($productId, $this->language);
        $optionDTO->setProduct($product);
        $assignedOptions    = ProductBusinessManager::getInstance(['language' => $this->language])->getAssignedOptions($productId);
        $optionDTO->setAssignedOptions($assignedOptions);
    }
    
    /**
     * Process save of assign options
     * @param array $postData
     */
    public function processSaveOptionValueAssignment($postData)
    {
        $productId  = $postData['product_id'];
        $optionId   = $postData['option_id'];
        $optionValueIdData = ArrayUtil::getValue($postData, 'option_value_id', []);
        $records    = ProductOptionMapping::find()->where('option_id = :aid AND product_id = :pid', [
                                                                                                    ':aid' => $optionId,
                                                                                                    ':pid' => $productId
                                                                                                ])->all();
        foreach($records as $record)
        {
            $record->delete();
        }
        if(!empty($optionValueIdData))
        {
            $this->saveOptionMappingDetails($postData);
        }
    }
    
    /**
     * Save option mapping details
     * @param array $postData
     */
    public function saveOptionMappingDetails($postData)
    {
        $optionValueMapping                 = new ProductOptionMapping(['scenario' => 'create']);
        $optionValueMapping->product_id     = $postData['product_id'];
        $optionValueMapping->option_id      = $postData['option_id'];
        $optionValueMapping->required       = $postData['required'];
        if($optionValueMapping->save())
        {
            foreach($postData['option_value_id'] as $index => $optionValueId)
            {    
                $optionMappingDetails                   = new ProductOptionMappingDetails(['scenario' => 'create']);
                $optionMappingDetails->mapping_id       = $optionValueMapping->id;
                $optionMappingDetails->option_value_id  = $optionValueId;
                if($postData['quantity'][$index] == null)
                {
                    $optionMappingDetails->quantity =  1;
                }
                else
                {
                    $optionMappingDetails->quantity       = $postData['quantity'][$index];
                }
                $optionMappingDetails->subtract_stock = $postData['subtract_stock'][$index];
                $optionMappingDetails->price_prefix   = $postData['price_prefix'][$index];
                $optionMappingDetails->price          = $postData['price'][$index];
                $optionMappingDetails->weight_prefix  = $postData['weight_prefix'][$index];
                $optionMappingDetails->weight         = $postData['weight'][$index];
                $optionMappingDetails->save();
            }    
        }
    }
    
    /**
     * inheritdoc
     */
    public function getPermissionPrefix($modelClass)
    {
        return 'product';
    }
}