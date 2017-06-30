<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\dto;
/**
 * FormDTO is the data transfer object for store
 *
 * @package common\modules\stores\dto
 */
class FormDTO extends \usni\library\dto\FormDTO
{
    private $_dataCategories;
    
    private $_owners;
    
    private $_themes;
    
    private $_currencies;
    
    private $_languages;
    
    private $_lengthClasses;
    
    private $_weightClasses;
    
    private $_taxBasedOnOptions;
    
    private $_customerGroupOptions;
    
    private $_orderStatusOptions;
    
    private $_currencySymbol;
    
    public function getDataCategories()
    {
        return $this->_dataCategories;
    }

    public function getOwners()
    {
        return $this->_owners;
    }

    public function getThemes()
    {
        return $this->_themes;
    }

    public function getCurrencies()
    {
        return $this->_currencies;
    }

    public function getLanguages()
    {
        return $this->_languages;
    }

    public function getLengthClasses()
    {
        return $this->_lengthClasses;
    }

    public function getWeightClasses()
    {
        return $this->_weightClasses;
    }

    public function getTaxBasedOnOptions()
    {
        return $this->_taxBasedOnOptions;
    }

    public function getCustomerGroupOptions()
    {
        return $this->_customerGroupOptions;
    }

    public function getOrderStatusOptions()
    {
        return $this->_orderStatusOptions;
    }

    public function setDataCategories($dataCategories)
    {
        $this->_dataCategories = $dataCategories;
    }

    public function setOwners($owners)
    {
        $this->_owners = $owners;
    }

    public function setThemes($themes)
    {
        $this->_themes = $themes;
    }

    public function setCurrencies($currencies)
    {
        $this->_currencies = $currencies;
    }

    public function setLanguages($languages)
    {
        $this->_languages = $languages;
    }

    public function setLengthClasses($lengthClasses)
    {
        $this->_lengthClasses = $lengthClasses;
    }

    public function setWeightClasses($weightClasses)
    {
        $this->_weightClasses = $weightClasses;
    }

    public function setTaxBasedOnOptions($taxBasedOnOptions)
    {
        $this->_taxBasedOnOptions = $taxBasedOnOptions;
    }

    public function setCustomerGroupOptions($customerGroupOptions)
    {
        $this->_customerGroupOptions = $customerGroupOptions;
    }

    public function setOrderStatusOptions($orderStatusOptions)
    {
        $this->_orderStatusOptions = $orderStatusOptions;
    }
    
    public function getCurrencySymbol()
    {
        return $this->_currencySymbol;
    }

    public function setCurrencySymbol($currencySymbol)
    {
        $this->_currencySymbol = $currencySymbol;
    }
}
