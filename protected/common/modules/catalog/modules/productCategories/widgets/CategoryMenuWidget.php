<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\widgets;

use yii\widgets\Menu;
use usni\UsniAdaptor;
/**
 * CategoryMenuWidget widget.
 * 
 * @package productCategories\widgets
 */
class CategoryMenuWidget extends \yii\bootstrap\Widget
{
    /**
     * @var array record for product category 
     */
    public $model;
    
    /**
     * inheritdoc
     */
    public function run()
    {
        $categoryData = UsniAdaptor::app()->session->get('globalMenuItems');
        $items          = $this->createMenuItems($categoryData);
        return Menu::widget([
                                'items'             => $items,
                                'encodeLabels'      => false,
                                'activateParents'   => true,
                                'options'         => array('class' => 'list-group', 'tag' => 'div'),
                                'submenuTemplate' => "{items}"
                           ]);
    }
    
    /**
     * Create menu items.
     * @return array
     */
    public function createMenuItems($categories)
    {
        $items      = [];
        foreach ($categories as $category)
        {
            $url    = $this->resolveUrl($category);
            $label  = $this->resolveLabel($category);
            //Check for sub menu items
            $item = array('label'   => $label,
                         'url'     => $url,
                         'options' => ['class' => 'list-group-item']);
            if(isset($category['hasChildren']) && $category['hasChildren'])
            {
               //We are getting sub menu items only if item is active
               $subMenuItems = $this->createMenuItems($category['children']);
               //$item['active'] = true;
               $item['items']  = $subMenuItems;
            }
            $items[] = $item;
        }
        return $items;
    }
    
    /**
     * Resolve url for the category
     * @param array $category
     * @return string
     */
    protected function resolveUrl($category)
    {
        if (!empty($category['custom_url']))
        {
            $url = $category['custom_url'];
        }
        else
        {
            $url = UsniAdaptor::createUrl('/catalog/productCategories/site/view', ['id' => $category['id']]);
        }
        return $url;
    }
    
    /**
     * Resolve label
     * @param array $category
     * @return string
     */
    protected function resolveLabel($category)
    {
        if($category['level'] == 0)
        {
            $label = $category['name'];
        }
        else
        {
            $label = str_repeat('-', $category['level']) .  ' ' . $category['name'];
            $label = str_repeat('&nbsp;', 2 * $category['level']) .  ' ' . $label;
        }
        return $label;
    }
}