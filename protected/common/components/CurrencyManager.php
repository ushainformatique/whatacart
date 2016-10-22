<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\components;

use common\modules\localization\modules\currency\models\Currency;
use usni\UsniAdaptor;
use usni\library\utils\CookieUtil;
use yii\web\Cookie;
use usni\library\utils\CacheUtil;
use common\modules\localization\modules\currency\utils\CurrencyUtil;
use usni\library\utils\ArrayUtil;
/**
 * CurrencyManager class file.
 * 
 * @package common\components
 */
class CurrencyManager extends \yii\base\Component
{
    /**
     * The cookie name for the currency for the interface.
     * @var string 
     */
    public $applicationCurrencyCookieName;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->applicationCurrencyCookieName == null)
        {
            throw new \yii\base\InvalidConfigException(UsniAdaptor::t('currency', 'missingCurrencyCookie'));
        }
    }
    
    /**
     * Get list of currencies.
     * @return array
     */
    public static function getList()
    {
        $currencies        = CacheUtil::get('allowedCurrenciesList');
        if($currencies === false)
        {
            $allowedCurrencies = CurrencyUtil::getAllCurrencies();
            $currencies = ArrayUtil::map($allowedCurrencies, 'code', 'code');
            CacheUtil::set('allowedCurrenciesList', $currencies);
        }
        return $currencies;
    }
    
    /**
     * Get default currency
     * @return string
     */
    public function getDefault()
    {
        $currency = CacheUtil::get('defaultCurrency');
        if($currency == false)
        {
            $currency = Currency::find()->where('value = :value', [':value' => 1])->asArray()->one();
            CacheUtil::set('defaultCurrency', $currency);
        }
        return $currency['code'];
    }
    
    /**
     * Get chosen currency by the user.
     * @return string
     */
    public function getDisplayCurrency()
    {
        $currencyCookieValue = CookieUtil::getValue($this->applicationCurrencyCookieName);
        if($currencyCookieValue != null)
        {
            return $currencyCookieValue;
        }
        else
        {
            return $this->getDefault();
        }
    }
    
    /**
     * Sets currency cookie.
     * @param string $currencyCode
     * @return void
     */
    public function setCookie($currencyCode)
    {
        $cookie = new Cookie([
                                    'name' => $this->applicationCurrencyCookieName,
                                    'value' => $currencyCode,
                                    'expire' => time() + 86400 * 2,
                                    'httpOnly' => true
                                ]);
        UsniAdaptor::app()->getResponse()->getCookies()->add($cookie);
    }  
    
    /**
     * Get currency symbol
     * @param string $currencyCode
     * @return string
     */
    public function getCurrencySymbol($currencyCode)
    {
        if($currencyCode == null)
        {
            $currencyCode  = UsniAdaptor::app()->currencyManager->getDisplayCurrency();
        }
        $currency = Currency::find()->where('code = :code', [':code' => $currencyCode])->asArray()->one();
        return html_entity_decode($currency['symbol_left']);
    }
}