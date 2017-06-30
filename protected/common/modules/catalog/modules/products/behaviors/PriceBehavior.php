<?php

/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\behaviors;
use usni\UsniAdaptor;

/**
 * Implements functions related to price
 *
 * @package products\behaviors
 */
class PriceBehavior extends \yii\base\Behavior
{
    /**
     * Get price based on the selected currency.
     * @param float $price
     * @param string $currencyCode selected currency code
     * @return float
     */
    public function getPriceByCurrency($price, $currencyCode)
    {
        $defaultCurrencyCode = UsniAdaptor::app()->currencyManager->defaultCurrency;
        if ($defaultCurrencyCode != $currencyCode)
        {
            $value = UsniAdaptor::app()->currencyManager->getCurrencyValue($currencyCode);
            $price = $value * $price;
        }
        return number_format($price, 2, ".", "");
    }

    /**
     * Get formatted price.
     * @param float $price
     * @param string $currencyCode selected currency code
     * @return string
     */
    public function getFormattedPrice($price, $currencyCode = null)
    {
        $defaultCurrencyCode = UsniAdaptor::app()->currencyManager->defaultCurrency;
        if ($currencyCode == null)
        {
            $currencyCode = $defaultCurrencyCode;
        }
        $priceByCurrency    = $this->getPriceByCurrency($price, $currencyCode);
        $currencySymbol     = UsniAdaptor::app()->currencyManager->getCurrencySymbol($currencyCode);
        return $this->getPriceWithSymbol($priceByCurrency, $currencySymbol);
    }

    /**
     * Get price with symbol.
     * @param float $priceByCurrency
     * @param string $currencySymbol
     * @return string
     */
    public function getPriceWithSymbol($priceByCurrency, $currencySymbol = null)
    {
        if ($currencySymbol == null)
        {
            $currencySymbol = UsniAdaptor::app()->currencyManager->currencySymbol;
        }
        return $currencySymbol . '' . $priceByCurrency;
    }

    /**
     * Get price in base currency.
     * @param float $price
     * @param float $conversionValue
     * @return float
     */
    public function getPriceByInBaseCurrency($price, $conversionValue)
    {
        if ($conversionValue != 0)
        {
            $basePrice = $price / $conversionValue;
            return number_format($basePrice, 2, ".", "");
        }
        return $price;
    }
}
