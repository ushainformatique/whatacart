<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace frontend\widgets;

use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use usni\library\utils\Html;
use usni\fontawesome\FA;
use yii\bootstrap\Dropdown;
/**
 * Renders My Account dropdown in header
 *
 * @package frontend\widgets
 */
class MyAccount extends \yii\bootstrap\Widget
{
    /**
     * Layout for the store selector
     * @var string 
     */
    public $layout = '<li class="dropdown">{headerLink}{listItems}</li>';
    
    /**
     * @var array Html options for header link 
     */
    public $headerLinkOptions = ['data-toggle' => 'dropdown', 'class' => 'dropdown-toggle'];
    
    /**
     * @var string My account url 
     */
    public $accountUrl;
    
    /**
     * @var string Label for my account 
     */
    public $accountLabel;
    
    /**
     * inheritdoc
     */
    public function run()
    {
        if($this->accountUrl == null)
        {
            if (!UsniAdaptor::app()->user->isGuest)
            {
                $this->accountUrl = UsniAdaptor::createUrl('customer/site/my-account');
            }
            else
            {
                $this->accountUrl = UsniAdaptor::createUrl('customer/site/login');
            }
        }
        if($this->accountLabel == null)
        {
            $this->accountLabel = UsniAdaptor::t('users', 'My Account');
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
        $username       = null;
        if (!UsniAdaptor::app()->user->isGuest)
        {
            $username   = UsniAdaptor::app()->user->getIdentity()->username;
        }
        if($username == null)
        {
            $linkText = Html::tag('span', $this->accountLabel, ['class' => "hidden-xs hidden-sm hidden-md"]);
        }
        else
        {
            $linkText = Html::tag('span', $username, ['class' => "hidden-xs hidden-sm hidden-md"]);
        }
        $headerLink     = $linkText . "\n" .
                          FA::icon('caret-down');
        $linkOptions    = ArrayUtil::merge($this->headerLinkOptions, ['title' => strip_tags($this->accountLabel)]);
        return Html::a($headerLink, $this->accountUrl, $linkOptions);
    }
    
    /**
     * Render list items
     * @return string
     */
    public function renderListItems()
    {
        $items          = [];
        if(!UsniAdaptor::app()->user->isGuest)
        {
            $items[] = ['label' => $this->accountLabel, 'url' => $this->accountUrl];
            $items[] = ['label' => UsniAdaptor::t('users', 'Logout'), 'url' => UsniAdaptor::createUrl('customer/site/logout')];
        }
        else
        {
            $items[] = ['label' => UsniAdaptor::t('users', 'Register'), 'url' => UsniAdaptor::createUrl('customer/site/register')];
            $items[] = ['label' => UsniAdaptor::t('users', 'Login'), 'url' => UsniAdaptor::createUrl('customer/site/login')];
        }
        return Dropdown::widget(['items'         => $items,
                                'options'       => ['class' => 'dropdown-menu dropdown-menu-right'],
                                'encodeLabels'  => false
                                ]);
    }
}
