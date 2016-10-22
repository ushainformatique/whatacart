<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\views\common;

use usni\library\views\UiView;
use usni\library\components\UiBaseActiveRecord;
use usni\UsniAdaptor;
use productCategories\models\ProductCategory;
use usni\library\utils\ConfigurationUtil;
use yii\widgets\Menu;
use productCategories\utils\ProductCategoryUtil;
/**
 * GlobalMenuView class file.
 *
 * @package frontend\views\common
 */
class GlobalMenuView extends UiView
{
    /**
     * Product category array
     * @var array 
     */
    protected $model;
    
    /**
     * Class constructor
     * @param ProductCategory $model
     */
    public function __construct()
    {
        if(isset($_GET['id']))
        {
            $this->model = ProductCategoryUtil::getCategoryById($_GET['id']);
        }
        else
        {
            $this->model = [];
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $dataCategory   = UsniAdaptor::app()->storeManager->getSelectedStoreDataCategory();
        $items          = $this->createMenuItems(0, $dataCategory);
        usort($items, ['frontend\utils\FrontUtil', 'compareItemsSort']);
        $containerClass = ConfigurationUtil::getValue('site', 'containerClass');
        return Menu::widget([
                                'items'             => $items,
                                'encodeLabels'      => false,
                                'activateParents'   => true,
                                'options'           => ['class' => $containerClass],
                                'linkTemplate'      => '<a href="{url}">{label}</a>',
                                'submenuTemplate'   => '<div class="dropdown-menu"><div class="dropdown-inner"><ul class="list-unstyled">{items}</ul></div></div>'
                           ]);
    }

    /**
     * Create menu items.
     * @param integer $parentId ParentId having id for parent item.
     * @param integer $storeDataCategory
     * @return boolean
     */
    public function createMenuItems($parentId = 0, $storeDataCategory)
    {
        $items      = [];
        $categories = ProductCategoryUtil::getTopMenuCategoriesByParent($parentId, $storeDataCategory);
        foreach ($categories as $category)
        {
            if ($category['status'] == UiBaseActiveRecord::STATUS_ACTIVE && $category['displayintopmenu'])
            {
                if($category['level'] <= 1)
                {
                    $subMenuItems = $this->createMenuItems($category['id'], $storeDataCategory);
                    if (!empty($category['custom_url']))
                    {
                        $url = $category['custom_url'];
                    }
                    else
                    {
                        $url = ['/catalog/productCategories/site/view', 'id' => $category['id']];
                    }
                    $caret      = null;
                    $options    = [];
                    //Check for sub menu items
                    if(count($subMenuItems) > 0)
                    {
                        $caret      = '<b class="caret"></b>';
                        $options    = ['class' => 'dropdown'];
                        $item       = [
                                            'label'   => $category['name'] . $caret,
                                            'url'     => $url,
                                            'items'   => $subMenuItems,
                                            'options' => $options,
                                        ];
                    }
                    else
                    {
                        $item = [
                                    'label'   => $category['name'] . $caret,
                                    'url'     => $url,
                                    'items'   => $subMenuItems,
                                    'options' => $options,
                                ];
                    }
                    $this->setSortOrder($category, $item);
                    $items[] = $item;
                }
            }
        }
        return $items;
    }

    /**
     * Sets sort order for the menu.
     * @param array $category
     * @param array $item
     * @return void
     */
    public function setSortOrder($category, & $item)
    {
        $menuSettingsSortOrder  = ConfigurationUtil::getValue('site', 'sortOrder');
        if(!empty($menuSettingsSortOrder))
        {
            $menuSettingsSortOrder = unserialize($menuSettingsSortOrder);
        }
        else
        {
            $menuSettingsSortOrder = array();
        }
        if(!empty($menuSettingsSortOrder) && $category['parent_id'] == 0 && in_array($category['id'], $menuSettingsSortOrder))
        {
            $flippedMenuSortData = array_flip($menuSettingsSortOrder);
            $item['sortOrder']   = $flippedMenuSortData[$category['id']] + 1;
        }
        else
        {
            $item['sortOrder'] = 0;
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        $script = "
                    $('.topnavbar ul > li:has(ul) > a').addClass('dropdown-toggle');
                    $('.topnavbar ul > li:has(ul) > a').attr('data-toggle', 'dropdown');
                  ";
        UsniAdaptor::app()->getView()->registerJs($script, \yii\web\View::POS_END, 'frontmenudisplay');
    }
}
?>