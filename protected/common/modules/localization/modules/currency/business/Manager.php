<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\currency\business;

use common\modules\localization\modules\currency\dao\CurrencyDAO;
use yii\base\InvalidParamException;
use usni\library\utils\CacheUtil;
use usni\library\utils\ArrayUtil;
use common\modules\localization\modules\currency\models\Currency;
/**
 * Manager class file.
 *
 * @package common\modules\localization\modules\currency\business
 */
class Manager extends \usni\library\business\Manager
{    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return CurrencyDAO::getAll($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model      = CurrencyDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Object not found: $id");
        }
        return $model;
    }
    
    /**
     * inheritdoc
     */
    public function afterModelSave($model)
    {
        CacheUtil::delete('allowedCurrenciesList');
        return true;
    }
    
    /**
     * Gets dropdown field select data.
     * @param string $key
     * @return array
     */
    public function getDropdownByKey($key)
    {
        $data = ArrayUtil::map(CurrencyDAO::getAll($this->language), $key, 'name');
        return $data;
    }
    
    /**
     * Get list of currencies.
     * @return array
     */
    public function getList()
    {
        return CurrencyDAO::getList();
    }
    
    /**
     * Get code list of currency.
     * @return array
     */
    public function getCodeList()
    {
        $allowedCurrencies = $this->getList();
        return ArrayUtil::map($allowedCurrencies, 'code', 'code');
    }
    
    /**
     * Get default currency.
     * @return string
     */
    public function getDefault()
    {
        $currency = Currency::find()->where('value = :value', [':value' => 1])->asArray()->one();
        return $currency['code'];
    }
}