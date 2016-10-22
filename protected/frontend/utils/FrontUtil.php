<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\utils;

use usni\UsniAdaptor;
use usni\library\utils\ConfigurationUtil;
use usni\library\utils\ArrayUtil;
use usni\library\components\UiHtml;
use productCategories\models\ProductCategory;
use productCategories\views\front\CategoryMenuView;
use usni\library\utils\StatusUtil;
/**
 * FrontUtil class file.
 *
 * @package frontend\utils
 */
class FrontUtil
{
    /**
     * Compare items sort.
     * @param array $firstItem
     * @param array $secondItem
     * @return int
     */
   public static function compareItemsSort($firstItem, $secondItem)
   {
       assert('is_array($firstItem)');
       assert('is_array($secondItem)');
       return $firstItem['sortOrder'] - $secondItem['sortOrder'];
   }

   /**
    * Sets default menu.
    * @param boolean $items
    */
   public static function setDefaultMenu(& $items)
   {
        $isAnyMenuItemActive = false;
        foreach($items as $item)
        {
            $isActive = ArrayUtil::getValue($item, 'active', null);
            if($isActive !== null && $isActive === true)
            {
                $isAnyMenuItemActive = true;
                break;
            }
        }
        if($isAnyMenuItemActive === false)
        {
            $items[0]['active'] = true;
        }
   }
   
    /**
     * Get default inner layout.
     * @return string
     */
    public static function getDefaultInnerLayout()
    {
        $themeName  = self::getThemeName();
        return "@webroot/themes/$themeName/views/layouts/singlecolumn";
    }
    
    /**
     * Get theme name.
     * @return string
     */
    public static function getThemeName()
    {
        if(YII_ENV != YII_ENV_TEST)
        {
            if(UsniAdaptor::app()->installed)
            {
                $store  = UsniAdaptor::app()->storeManager->getCurrentStore();
                return $store->theme;
            }
            else
            {
                return ConfigurationUtil::getValue('application', 'frontTheme');
            }
        }
        else
        {
            return 'classic';
        }
    }
    
    /**
     * Get default inner layout.
     * @return string
     */
    public static function getDefaultViewLayout()
    {
        $themeName  = self::getThemeName();
        return "@webroot/themes/$themeName/views/layouts/newmain";
    }
    
    /**
     * Get default preview layout.
     * @return string
     */
    public static function getDefaultPreviewLayout()
    {
        $themeName  = self::getThemeName();
        return "@approot/themes/$themeName/views/layouts/newmain";
    }
    
    /**
     * Set theme.
     * @return void
     */
    public static function setTheme()
    {
        $theme = ConfigurationUtil::getValue('application', 'frontTheme');
        if($theme == null)
        {
            $theme = 'classic';
        }
        $themeData = [
            'class'    => 'yii\base\Theme',
            'basePath' => '@webroot/themes/' . $theme,
            'baseUrl'  => '@web/themes/' . $theme
        ];
        UsniAdaptor::app()->getView()->theme = \Yii::createObject($themeData);
    }
    
    /**
     * Render top nav login view.
     * @return string
     */
    public static function renderTopnavLoginview()
    {
        $isRegAllowed = ConfigurationUtil::getValue('application', 'isRegistrationAllowed');
        if($isRegAllowed != null && ((bool)$isRegAllowed === true))
        {
            if(UsniAdaptor::app()->user->isGuest)
            {
                $links  = UiHtml::a(UsniAdaptor::t('users', 'Login'), UsniAdaptor::createUrl('users/front/login')) .'&nbsp or &nbsp';
                $links .= UiHtml::a(UsniAdaptor::t('users', 'Register'), UsniAdaptor::createUrl('users/front/register'));
                return $links;
            }
            else
            {
                return 'You are logged in as &nbsp'.
                       UiHtml::a(UsniAdaptor::app()->user->identity->username, UsniAdaptor::createUrl('users/front/logout')) . ' ' .
                       '(' . UiHtml::a('Logout', UsniAdaptor::createUrl('users/front/logout')) . ')';
            }
        }
    }
    
    /**
     * Renders global menu
     * @return string
     */
    public static function renderGlobalMenu()
    {
        $globalViewClassName    = UsniAdaptor::app()->viewHelper->globalMenuView;
        $menuView               = new $globalViewClassName();
        return $menuView->render();
    }
    
    /**
     * Renders sidebar menu
     * @return string
     */
    public static function renderSidebarMenu()
    {
        $menuView  = new CategoryMenuView(new ProductCategory());
        return $menuView->render();
    }
    
    /**
     * Renders my account text in the top navigation
     * @param boolean $isGuest
     * @return string
     */
    public static function renderMyAccountText($isGuest)
    {
        if($isGuest)
        {
            $url = UsniAdaptor::createUrl('customer/site/login');
        }
        else
        {
            $url = UsniAdaptor::createUrl('customer/site/my-account');
        }
        return UiHtml::a(UsniAdaptor::t('users', 'My Account'), $url);
    }
    
    /**
     * Renders sub view.
     * @param string $className
     * @return string
     */
    public static function renderSubView($className)
    {
        $instance = new $className();
        return $instance->render();
    }
        
    /**
     * Get list of parent menu items for front end.
     * @param array $sortOrderData
     * @return array
     */
    public static function getTopMenuItemsList($sortOrderData = [])
    {
        $items         = [];
        $sortedItems   = [];
        $categories    = ProductCategory::find()->where('parent_id = :parent_id AND status = :status AND displayintopmenu = :dp')
                                                                ->params(array(':parent_id' => 0, ':status' => StatusUtil::STATUS_ACTIVE,
                                                                               ':dp' => 1))->all();
        $items         = ArrayUtil::map($categories, 'id', 'name');
        //Sort the items here
        if(!empty($sortOrderData))
        {
            foreach ($sortOrderData as $sortOrderId)
            {
                $sortedItems[$sortOrderId] = $items[$sortOrderId];
                unset($items[$sortOrderId]);
            }
            $sortedItems = ArrayUtil::merge($sortedItems, $items);
        }
        else
        {
            $sortedItems = $items;
        }
        return $sortedItems;
    }
}
?>