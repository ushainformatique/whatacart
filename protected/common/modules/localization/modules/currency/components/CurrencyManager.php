<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\components;

/**
 * Global application component related to currency
 * 
 * @package common\modules\localization\modules\currency\components
 */
class CurrencyManager extends \yii\base\Component
{
    /**
     * List of currencies in the database.
     * @var array
     */
    public $currencies;
    
    /**
     * Default currency.
     * @var string
     */
    public $defaultCurrency;
    
    /**
     * Currency symbol.
     * @var string
     */
    public $currencySymbol;
    
    /**
     * List of currency codes
     * @var array
     */
    public $currencyCodes;

    /**
     * Selected currency.
     * @var string 
     */
    public $selectedCurrency;

    /**
     * Get chosen currency symbol
     * @return string
     */
    public function getSelectedCurrencySymbol()
    {
        return $this->getCurrencySymbol($this->selectedCurrency);
    }
    
    /**
     * Get currency by code.
     * @param string $currencyCode
     * @return array
     */
    public function getCurrencyByCode($currencyCode)
    {
        $currencyList = $this->currencies;
        foreach($currencyList as $currency)
        {
            if($currency['code'] == $currencyCode)
            {
                return $currency;
            }
        }
        return null;
    }
    
    /**
     * Get currency value
     * @param string $currencyCode
     * @return string
     */
    public function getCurrencyValue($currencyCode)
    {
        $currency = $this->getCurrencyByCode($currencyCode);
        if(!empty($currency))
        {
            return $currency['value'];
        }
        $defaultCurrency = $this->getCurrencyByCode($currencyCode);
        return $defaultCurrency['value'];
    }
    
    /**
     * Get chosen currency symbol
     * @param string $currencyCode
     * @return string
     */
    public function getCurrencySymbol($currencyCode)
    {
        $currency = $this->getCurrencyByCode($currencyCode);
        if(!empty($currency))
        {
            return $currency['symbol_left'];
        }
        $defaultCurrency = $this->getCurrencyByCode($this->defaultCurrency);
        return $defaultCurrency['symbol_left'];
    }
}