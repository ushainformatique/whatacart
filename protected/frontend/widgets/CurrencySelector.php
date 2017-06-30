<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace frontend\widgets;

use usni\library\utils\Html;
use yii\bootstrap\Dropdown;
use usni\fontawesome\FA;
use usni\UsniAdaptor;
/**
 * CurrencySelector renders currency selection dropdown
 *
 * @package frontend\widgets
 */
class CurrencySelector extends \yii\bootstrap\Widget
{
    /**
     * Selected currency
     * @var array 
     */
    public $selectedCurrency;
    
    /**
     * List of currencies
     * @var array 
     */
    public $currencies;
    
    /**
     * Layout for the store selector
     * @var string 
     */
    public $layout = '<li class="dropdown">{headerLink}{listItems}</li>';
    
    /**
     * Action url for the store change action
     * @var string 
     */
    public $actionUrl = 'stores/default/set-store';
    
    /**
     * @var array Html options for header link 
     */
    public $headerLinkOptions = ['data-toggle' => 'dropdown', 'class' => 'dropdown-toggle'];
    
    /**
     * inheritdoc
     */
    public function run()
    {
        if(count($this->currencies) <= 1)
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
     * @param string $name the section name, e.g., `{summary}`, `{items}`.
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
        $headerLink     = Html::tag('span', $this->selectedCurrency) . "\n" .
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
        foreach($this->currencies as $key => $value)
        {
            $items[] = ['label' => $value, 'url' => '#', 'linkOptions' => ['class' => 'currency-selector', 'data-currency-id' => $key]];
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
        $url    = UsniAdaptor::app()->request->url;
        $getUrl = UsniAdaptor::createUrl($this->actionUrl);
        $script = "$('.currency-selector').click(function(){
                                                    var value = $(this).data('currency-id');
                                                    $.ajax({
                                                            'type':'GET',
                                                            'url':'{$getUrl}' + '?currency=' + value,
                                                            'success':function(data)
                                                                      {
                                                                        window.location.href = '{$url}';
                                                                      }
                                                          });
                                                    return false;
                                                 });";
        $this->getView()->registerJs($script);
    }
}
