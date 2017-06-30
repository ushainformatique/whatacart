<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\widgets;

use usni\library\utils\Html;
use yii\bootstrap\Dropdown;
use usni\fontawesome\FA;
use usni\UsniAdaptor;
/**
 * LanguageSelector renders language selection dropdown
 *
 * @package backend\widgets
 */
class LanguageSelector extends \yii\bootstrap\Widget
{
    /**
     * Selected language
     * @var string 
     */
    public $selectedLanguage;
    
    /**
     * Translated languages
     * @var array 
     */
    public $translatedLanguages;
    
    /**
     * Application languages
     * @var array 
     */
    public $languages;
    
    /**
     * Layout for the language selector
     * @var string 
     */
    public $layout = '<li class="dropdown">{headerLink}{listItems}</li>';
    
    /**
     * Action url for the language change action
     * @var string 
     */
    public $actionUrl = '/users/default/change-language';
    
    /**
     * @var array Html options for header link 
     */
    public $headerLinkOptions = ['data-toggle' => 'dropdown', 'class' => 'dropdown-toggle', 'style' => "color:white"];
    
    /**
     * inheritdoc
     */
    public function run()
    {
        if(empty($this->translatedLanguages))
        {
            return null;
        }
        $content = preg_replace_callback("/{\\w+}/", function ($matches) {
                $content = $this->renderSection($matches[0]);

                return $content === false ? $matches[0] : $content;
            }, $this->layout);
        $this->registerScripts();
        return $content;
    }
    
    /**
     * Renders a section of the specified name.
     * If the named section is not supported, false will be returned.
     * @param string $name the section name, e.g., `{headerLink}`, `{listItems}`.
     * @return string|boolean the rendering result of the section, or false if the named section is not supported.
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{headerLink}':
                return $this->renderHeaderLink();
            case '{listItems}':
                return $this->renderListItems();
            default:
                return false;
        }
    }
    
    /**
     * Render header link
     * @return string
     */
    public function renderHeaderLink()
    {
        $languageText   = $this->languages[$this->selectedLanguage];
        $headerLink     = Html::tag('span', $languageText) . "\n" .
                          FA::icon('caret-down');
        return Html::a($headerLink, '#', $this->headerLinkOptions);
    }
    
    /**
     * Render list items
     * @return string
     */
    public function renderListItems()
    {
        $items          = [];
        foreach($this->languages as $key => $value)
        {
            $items[] = ['label' => $value, 'url' => '#', 'linkOptions' => ['class' => 'language-selector', 'data-language-id' => $key]];
        }
        return Dropdown::widget(['items'         => $items,
                                'options'       => ['class' => 'dropdown-menu dropdown-menu-right'],
                                'encodeLabels'  => false
                                ]);
    }
    
    /**
     * Register scripts
     */
    public function registerScripts()
    {
        $url    = UsniAdaptor::app()->request->getUrl();
        $getUrl = UsniAdaptor::createUrl($this->actionUrl);
        $script = "$('.language-selector').click(function(){
                                                    var value = $(this).data('language-id');
                                                    $.ajax({
                                                            'type':'GET',
                                                            'url':'{$getUrl}' + '?language=' + value,
                                                            'success':function(data)
                                                                      {
                                                                          window.location.href = '{$url}';
                                                                      }
                                                          });
                                                 });";
        $this->getView()->registerJs($script);
    }
}
