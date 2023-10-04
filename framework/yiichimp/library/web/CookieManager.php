<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web;

use usni\UsniAdaptor;
use yii\web\Cookie;
use usni\library\utils\CookieUtil;
/**
 * Manages the functionality related to cookies in the application
 *
 * @package usni\library\web
 */
class CookieManager extends \yii\base\Component
{
    /**
     * The cookie name for the language in which content of the interface would be displayed.
     * In case of frontend, it would be same as applicationLanguageCookieName.
     * @var string 
     */
    public $contentLanguageCookieName;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->contentLanguageCookieName == null)
        {
            throw new \yii\base\InvalidConfigException();
        }
    }
    
    /**
     * Sets language cookie.
     * @param string $language
     * @return void
     */
    public function setLanguageCookie($language)
    {
        $cookie = new Cookie([
                                    'name' => $this->contentLanguageCookieName,
                                    'value' => $language,
                                    'expire' => time() + 86400 * 2,
                                    'httpOnly' => true
                                ]);
        UsniAdaptor::app()->getResponse()->getCookies()->add($cookie);
    }
    
    /**
     * Get chosen language by the user to render content. In this case display language could be different for the application.
     * For example in admin we have display language as english but on grid view, we can change the language and check the content.
     * @return string
     */
    public function getSelectedLanguage()
    {
        $value = CookieUtil::getValue($this->contentLanguageCookieName);
        if($value == null)
        {
            $value = UsniAdaptor::app()->language;
        }
        return $value;
    }
}
