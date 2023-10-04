<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\components;

/**
 * Global application component related to language. It consists of properties which should be populated
 * before action is executed.
 * 
 * @package usni\library\components
 */
class LanguageManager extends \yii\base\Component
{
    /**
     * List of languages in the database
     * @var array
     */
    public $languages;
    
    /**
     * List of translated languages in the database
     * @var array
     */
    public $translatedLanguages;
    
    /**
     * Selected language by the user. In case of admin panel it could be different from app language.
     * In case of front end, it would be same. 
     * @var string
     */
    public $selectedLanguage;
}