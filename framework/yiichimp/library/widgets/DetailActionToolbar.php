<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\widgets;

use usni\UsniAdaptor;
use usni\library\utils\Html;
use usni\fontawesome\FA;
use yii\bootstrap\Dropdown;
/**
 * Render action toolbar on top of detail view
 *
 * @package usni\library\widgets
 */
class DetailActionToolbar extends \yii\bootstrap\Widget
{
    /**
     * Delete url for the model
     * @var string 
     */
    public $deleteUrl; 
    
    /**
     * Edit url for the model
     * @var string 
     */
    public $editUrl;
    
    /**
     * Layout for the action toolbar
     * @var string 
     */
    public $layout = '<div class="pull-right btn-group">{headerLink}{listItems}</div>';
    
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
        $headerLink     = UsniAdaptor::t('application', 'Options') . "\n" .
                          FA::icon('caret-down');
        return Html::button($headerLink, ['data-toggle' => 'dropdown', 'class' => 'btn-warning btn-sm btn dropdown-toggle']);
    }
    
    /**
     * Render list items
     * @return string
     */
    public function renderListItems()
    {
        $items  = $this->getListItems();
        return Dropdown::widget(['items'         => $items,
                                'options'       => ['class' => 'dropdown-menu dropdown-menu-right'],
                                'encodeLabels'  => false
                                ]);
    }
    
    /**
     * Get list items
     * @return array
     */
    public function getListItems()
    {
        $items = [];
        if($this->editUrl != null)
        {
            $items[]    = ['label' => FA::icon('pencil') . "\n" . UsniAdaptor::t('application', 'Edit'), 
                           'url' => $this->editUrl];
        }
        if($this->deleteUrl != null)
        {
            $items[]    = ['label' => FA::icon('trash-o') . "\n" . UsniAdaptor::t('application', 'Delete'), 
                       'url' => $this->deleteUrl];
        }
        return $items;
    }
}
