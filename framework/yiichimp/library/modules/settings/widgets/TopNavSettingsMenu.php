<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace usni\library\modules\settings\widgets;

use usni\library\utils\Html;
use yii\bootstrap\Dropdown;
use usni\fontawesome\FA;
use usni\UsniAdaptor;
/**
 * TopNavSettingsMenu renders settings dropdown in top navigation
 *
 * @package usni\library\modules\settings\widgets
 */
class TopNavSettingsMenu extends \yii\bootstrap\Widget
{
    /**
     * @var boolean 
     */
    public $allowSiteSettings;
    /**
     * @var boolean 
     */
    public $allowMailSettings;
    /**
     * @var boolean 
     */
    public $allowDatabaseSettings;
    /**
     * @var boolean 
     */
    public $allowUserSettings;
    
    /**
     * Layout for the top nav menu
     * @var string 
     */
    public $layout = '<li class="dropdown">{headerLink}{listItems}</li>';
    
    /**
     * Template for each link in the dropdown
     * @var string 
     */
    public $linkTemplate = '<li><a href="{link}">{icon}{label}</a></li>';
    
    /**
     * List of link items
     * @var array 
     */
    public $items = [];
    
    /**
     * inheritdoc
     */
    public function run()
    {
        $user = UsniAdaptor::app()->user;
        if(!$user->can('access.settings'))
        {
            return null;
        }
        $this->allowSiteSettings = $user->can('settings.site');
        $this->allowMailSettings = $user->can('settings.email');
        $this->allowDatabaseSettings = $user->can('settings.database');
        $this->allowUserSettings = $user->can('user.settings');

        $isAllowed =$this->allowSiteSettings || $this->allowMailSettings || $this->allowDatabaseSettings || $this->allowUserSettings;
        if(!$isAllowed)
        {
            return null;
        }
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
        $headerLink     = FA::icon('cog') . "\n" . 
                          Html::tag('span', UsniAdaptor::t('settings', 'Settings'), ['class' => 'topnav-settings']) . "\n" .
                          FA::icon('caret-down');
        return Html::a($headerLink, '#', ['data-toggle' => 'dropdown', 'class' => 'dropdown-toggle', 'style' => "color:white"]);
    }
    
    /**
     * Render list items
     * @return string
     */
    public function renderListItems()
    {
        $this->renderSiteSettings();
        $this->renderEmailSettings();
        $this->renderUserSettings();
        $this->renderDatabaseSettings();
        return Dropdown::widget(['items'         => $this->items,
                                'options'       => ['class' => 'dropdown-menu dropdown-menu-right'],
                                'encodeLabels'  => false
                                ]);
    }
    
    /**
     * Render site settings
     */
    protected function renderSiteSettings()
    {
        if($this->allowSiteSettings)
        {
            $this->items[] = strtr($this->linkTemplate, ['{icon}' => FA::icon('sitemap'),
                                                         '{link}' => UsniAdaptor::createUrl('/settings/default/site'),
                                                         '{label}' => UsniAdaptor::t('application', 'Site')]);
        }
    }
    
    /**
     * Render email settings
     */
    protected function renderEmailSettings()
    {
        if($this->allowMailSettings)
        {
            $this->items[] = strtr($this->linkTemplate, ['{icon}' => FA::icon('envelope'),
                                                         '{link}' => UsniAdaptor::createUrl('/settings/default/email'),
                                                         '{label}' => UsniAdaptor::t('users', 'Email')]);
        }
    }
    
    /**
     * Render user settings
     */
    protected function renderUserSettings()
    {
        if($this->allowUserSettings)
        {
            $this->items[] = strtr($this->linkTemplate, ['{icon}' => FA::icon('user'),
                                                         '{link}' => UsniAdaptor::createUrl('/users/default/settings'),
                                                         '{label}' => UsniAdaptor::t('users', 'User')]);
        }
    }
    
    /**
     * Render database settings
     */
    protected function renderDatabaseSettings()
    {
        if($this->allowDatabaseSettings)
        {
            $this->items[] = strtr($this->linkTemplate, ['{icon}' => FA::icon('database'),
                                                         '{link}' => UsniAdaptor::createUrl('/settings/default/database'),
                                                         '{label}' => UsniAdaptor::t('settings', 'Database Settings')]);
        }
    }
}
