<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\web;

use usni\UsniAdaptor;
use yii\web\Cookie;
use usni\library\utils\CookieUtil;
use common\modules\stores\models\Store;
/**
 * Manages the functionality related to cookies in the application
 *
 * @package common\web
 */
class CookieManager extends \usni\library\web\CookieManager
{
    /**
     * The cookie name for the store name.
     * @var string 
     */
    public $applicationStoreCookieName;
    
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
        if($this->applicationStoreCookieName == null || $this->applicationCurrencyCookieName == null)
        {
            throw new \yii\base\InvalidConfigException();
        }
    }
    
    /**
     * Sets currency cookie.
     * @param string $currencyCode
     * @return void
     */
    public function setCurrencyCookie($currencyCode)
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
     * Get chosen currency by the user.
     * @return string
     */
    public function getSelectedCurrency()
    {
        $value = CookieUtil::getValue($this->applicationCurrencyCookieName);
        if($value == null)
        {
            return UsniAdaptor::app()->currencyManager->defaultCurrency;
        }
        return $value;
    }
    
    /**
     * Get current store id
     * @return integer
     */
    public function getSelectedStoreId()
    {
        $value = CookieUtil::getValue($this->applicationStoreCookieName);
        if($value == null)
        {
            $value = Store::DEFAULT_STORE_ID;
        }
        return $value;
    }
    
    /**
     * Sets store cookie.
     * @param string $storeId
     * @return void
     */
    public function setStoreCookie($storeId)
    {
        $cookie = new Cookie([
                                    'name'      => $this->applicationStoreCookieName,
                                    'value'     => $storeId,
                                    'expire'    => time() + 86400 * 2,
                                    'httpOnly'  => true
                                ]);
        UsniAdaptor::app()->getResponse()->getCookies()->add($cookie);
    }
}