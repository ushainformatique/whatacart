<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace usni\library\widgets;

/**
 * Tabs renders the content as bootstrap tabs.
 * @see \usni\library\modules\users\views\view.php
 *
 * @package usni\library\modules\users\widgets
 */
class Tabs extends \yii\bootstrap\Widget
{
    /**
     * Layout for the tabbed view
     * @var string 
     */
    public $layout = '<div class="tabbable"><ul class="nav nav-tabs">{headerLink}</ul><div class="tab-content with-padding">{listItems}</div></div>';
    
    /**
     * Template for each link in the tab header
     * @var string 
     */
    public $linkTemplate = '<li{class}><a href="{link}" data-toggle="tab">{label}</a></li>';
    
    /**
     * Content template for each tab content
     * @var string 
     */
    public $contentTemplate = '<div id="{id}" class="tab-pane{class}">{content}</div>';
    
    /**
     * List of tabs
     * @var array 
     */
    public $items = [];
    
    /**
     * inheritdoc
     */
    public function run()
    {
        $content = preg_replace_callback("/{\\w+}/", function ($matches) {
                $content = $this->renderSection($matches[0]);

                return $content === false ? $matches[0] : $content;
            }, $this->layout);
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
        $content = null;
        if(!empty($this->items))
        {
            foreach($this->items as $item)
            {
                $class = null;
                if(isset($item['class']))
                {
                    $class = " class = " . $item['class'];
                }
                $content .= strtr($this->linkTemplate, ['{link}' => '#' . $item['options']['id'], '{label}' => $item['label'], '{class}' => $class]);
            }
        }
        return $content;
    }
    
    /**
     * Render list items
     * @return string
     */
    public function renderListItems()
    {
        $content = null;
        if(!empty($this->items))
        {
            foreach($this->items as $item)
            {
                $class = null;
                if(isset($item['class']))
                {
                    $class = $item['class'];
                }
                $content .= strtr($this->contentTemplate, ['{id}' => $item['options']['id'], '{content}' => $item['content'], '{class}' => ' ' . $class]);
            }
        }
        return $content;
    }
}