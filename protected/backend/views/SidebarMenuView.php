<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\views;

use usni\library\utils\ArrayUtil;
use usni\library\components\AdminMenuRenderer;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
/**
 * Extended sidebar menu view
 * 
 * @package backend\views
 */
class SidebarMenuView extends \usni\library\views\UiMenuView
{
    /**
     * @inheritdoc
     */
    protected function customizeMenuRendering($menuItems)
    {
        $allItems           = [];
        $additionalGroupedMenuItems     = []; //For example sales and extensions
        $moveUnderMenuHeading           = []; //For example manufacturer moved under catalog
        $menuHeaderItems                = AdminMenuRenderer::getSidebarMenuHeaderItems();
        foreach($menuItems as $key => $value)
        {
            $headerLabel = ArrayUtil::getValue($menuHeaderItems, $key);
            if($headerLabel != null)
            {
                //In case of manufacturer header label is equal to Catalog thus we need to add it under catalog
                $targetModuleKey = $this->checkIfHeaderLabelExistUnderMenuItems($headerLabel, $menuItems);
                if($targetModuleKey === false)
                {
                    $additionalGroupedMenuItems[$headerLabel]['items'][] = $value[0];
                    //unset from $menuItems as moved under a different header
                    unset($menuItems[$key]);
                }
                else
                {
                    $moveUnderMenuHeading[$key] = $targetModuleKey;
                }
            }
            else
            {
                //The menus which doent have to be moved
                $allItems[$key] = $value[0];
            }
        }
        //Move the modules under existing module heading like manufacturer under catalog
        foreach($menuItems as $key => $value)
        {
            $isKeyExists = ArrayUtil::getValue($moveUnderMenuHeading, $key);
            if($isKeyExists)
            {
                $targetKey = $moveUnderMenuHeading[$key];
                $allItems[$targetKey]['items'][] = $value[0];
            }
        }
        $allItems = array_values($allItems);
        //Set the grouped items by creating a menu item
        foreach($additionalGroupedMenuItems as $headerLabel => $data)
        {
            $iconMap  = self::getSidebarHeaderToIconMap();
            $menuItem = [
                        'label' => AdminMenuRenderer::getSidebarMenuIcon($iconMap[$headerLabel]) . 
                                       AdminUtil::wrapSidebarMenuLabel($headerLabel),
                        'url'   => ['#'],
                        'itemOptions' => [
                                    'class' => 'navblock-header'
                                ],
                        'items' => $data['items']
                    ];
            $allItems[] = $menuItem;
        }
        return $allItems;
    }
    
    /**
     * Check if header label exists and if yes update the items with the input item
     * @param string $headerLabel
     * @param array $menuItems
     * @return boolean
     */
    protected function checkIfHeaderLabelExistUnderMenuItems($headerLabel, $menuItems)
    {
        $isFound   = false;
        foreach($menuItems as $key => $value)
        {
            $label = strip_tags($value[0]['label']);
            if($label == $headerLabel)
            {
                //Target module under which menu would move
                $isFound = $key;
            }
        }
        return $isFound;
    }


    /**
     * Get sidebar header to icon map
     * @return array
     */
    public static function getSidebarHeaderToIconMap()
    {
        return [
                    UsniAdaptor::t('application', 'System') => 'cog',
                    UsniAdaptor::t('application', 'Sales') => 'shopping-cart',
                    UsniAdaptor::t('application', 'Extensions') => 'puzzle-piece'
                ];
    }
}