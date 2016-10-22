<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\views\front;

use usni\library\views\UiView;
use productCategories\models\ProductCategory;
use usni\library\components\UiBaseActiveRecord;
use yii\widgets\Menu;
use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
use productCategories\models\ProductCategoryTranslated;
/**
 * CategoryMenuView class file
 * @package productCategories\views\front
 */
class CategoryMenuView extends UiView
{
    /**
     * Contain model.
     * @var Model 
     */
    public $model;

    /**
     * Class constructor
     * 
     * @param $model ProductCategory
     */
    public function __construct($model)
    {
        $this->model = $model;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $items          = $this->createMenuItems(0);
        $containerClass = 'list-group';
        FrontUtil::setDefaultMenu($items);
        return Menu::widget([
                                'items'           => $items,
                                'encodeLabels'    => false,
                                'activateParents' => true,
                                'options'         => array('class' => $containerClass, 'tag' => 'div'),
                                'submenuTemplate' => "{items}",

                           ]);
    }

    /**
     * Create menu items.
     * @param integer $parentId ParentId having id for parent item.
     * @return boolean
     */
    public function createMenuItems($parentId = 0)
    {
        $items      = [];
        $language   = UsniAdaptor::app()->languageManager->getDisplayLanguage();
        $tableName  = ProductCategory::tableName();
        $trTableName = ProductCategoryTranslated::tableName();
        $query      = (new \yii\db\Query());
        $categories     = $query->select('pc.*, pct.name, pct.alias')->from($tableName . ' pc')
                                ->innerJoin($trTableName . ' pct', 'pc.id = pct.owner_id')
                                ->where('pct.language = :lan AND parent_id = :pId AND data_category_id = :dci', 
                                    [':pId'  => $parentId, ':dci' => UsniAdaptor::app()->storeManager->getSelectedStoreDataCategory(),
                                     ':lan' => $language])
                                ->all();
        foreach ($categories as $category)
        {
            if ($category['status'] == UiBaseActiveRecord::STATUS_ACTIVE && $category['displayintopmenu'])
            {
                if (!empty($category['custom_url']))
                {
                    $url = $category['custom_url'];
                }
                else
                {
                    $url = UsniAdaptor::createUrl('/catalog/productCategories/site/view', ['id' => $category['id']]);
                }
                if($category['level'] == 0)
                {
                    $label = $category['name'];
                }
                else
                {
                    $label = str_repeat('-', $category['level']) .  ' ' . $category['name'];
                    $label = str_repeat('&nbsp;', 2 * $category['level']) .  ' ' . $label;
                }
                //Check for sub menu items
                $item = array('label'   => $label,
                              'url'     => $url,
                              'options' => ['class' => 'list-group-item']);
                if ($this->model instanceof ProductCategory && $this->model->alias == $category['alias'])
                {
                    //We are getting sbub menu items only if item is active
                    $subMenuItems = $this->createMenuItems($category['id']);
                    $item['active'] = true;
                    $item['items']  = $subMenuItems;
                }
                $items[] = $item;
            }
        }
        return $items;
    }
}
?>