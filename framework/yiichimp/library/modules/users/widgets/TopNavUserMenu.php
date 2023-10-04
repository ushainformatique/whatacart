<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace usni\library\modules\users\widgets;

use usni\library\utils\Html;
use yii\bootstrap\Dropdown;
use usni\fontawesome\FA;
use usni\UsniAdaptor;
/**
 * TopNavUserMenu renders user dropdown in top navigation
 *
 * @package usni\library\modules\users\widgets
 */
class TopNavUserMenu extends \yii\bootstrap\Widget
{
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
        $model          = UsniAdaptor::app()->user->getIdentity();
        $headerLink     = FA::icon('cog') . "\n" . 
                          Html::tag('span', $model->username) . "\n" .
                          FA::icon('caret-down');
        return Html::a($headerLink, '#', ['data-toggle' => 'dropdown', 'class' => 'dropdown-toggle', 'style' => "color:white"]);
    }
    
    /**
     * Render list items
     * @return string
     */
    public function renderListItems()
    {
        $this->renderLogOutLink();
        $this->renderMyProfileLink();
        $this->renderChangePasswordLink();
        return Dropdown::widget(['items'         => $this->items,
                                'options'       => ['class' => 'dropdown-menu dropdown-menu-right'],
                                'encodeLabels'  => false
                                ]);
    }
    
    /**
     * Render logout link
     */
    protected function renderLogOutLink()
    {
        $logoutLabel    = FA::icon('sign-out') . "\n" . UsniAdaptor::t('users', 'Logout');
        $this->items[]  = ['label'      => $logoutLabel,
                           'url'        => UsniAdaptor::createUrl('/users/default/logout'),
                           'visible'    => true];
    }
    
    /**
     * Render my profile link
     */
    protected function renderMyProfileLink()
    {
        $model          = UsniAdaptor::app()->user->getIdentity();
        $profileLabel   = FA::icon('user') . "\n" . UsniAdaptor::t('users', 'My Profile');
        $this->items[]  = ['label'      => $profileLabel,
                           'url'        => UsniAdaptor::createUrl('/users/default/view', ['id' => $model->id]),
                           'visible'    => true];
    }
    
    /**
     * Render change password link
     */
    protected function renderChangePasswordLink()
    {
        if(UsniAdaptor::app()->user->can('user.change-password'))
        {
            $model              = UsniAdaptor::app()->user->getIdentity();
            $passwordLabel      = FA::icon('lock') . "\n" . UsniAdaptor::t('users', 'Change Password');
            $item               = ['label'      => $passwordLabel,
                                   'url'        => UsniAdaptor::createUrl('/users/default/change-password', ['id' => $model->id]),
                                   'visible'    => true];
            $this->items[]      = $item;
        }
    }
}
