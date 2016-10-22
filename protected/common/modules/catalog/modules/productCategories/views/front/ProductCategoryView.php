<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace productCategories\views\front;

use frontend\utils\FrontUtil;
use productCategories\models\ProductCategory;
use products\models\Product;
use products\views\front\SortByView;
use products\views\front\ShowItemsPerPageView;
use products\views\front\ShowListOrGridView;
use frontend\views\FrontPageView;
use productCategories\views\front\CategoryMenuView;
use usni\UsniAdaptor;
use usni\library\utils\FileUploadUtil;
use frontend\views\common\SearchResultsListView;
use frontend\models\SearchForm;
use common\modules\stores\utils\StoreUtil;

/**
 * ProductCategoryView class file.
 *
 * @package productCategories\views
 */
class ProductCategoryView extends FrontPageView
{
    /**
     * Category model.
     * @var ProductCategory
     */
    public  $category;
    
    /**
     * Search model
     * @var SearchForm 
     */
    public $searchModel;
    
    /**
     * @inheritdoc
     */
    public function __construct($category)
    {
        $this->category     = $category;
        $this->searchModel  = new SearchForm(['categoryId' => $this->category->id]);
    }
    
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $currentStore           = UsniAdaptor::app()->storeManager->getCurrentStore();
        $storeId                = $currentStore->id;
        $productListView        = new SearchResultsListView(['model' => new Product(), 'searchFormModel' => $this->searchModel]);
        $productList            = $productListView->render();
        $sortBy                 = new SortByView($productListView->pjaxContainerId);
        $show                   = new ShowItemsPerPageView($productListView->pjaxContainerId);
        $listOrGrid             = new ShowListOrGridView($productListView->pjaxContainerId);
        $theme                  = FrontUtil::getThemeName();
        $categoryWidth          = StoreUtil::getImageSetting('category_image_width', 90);
        $categoryHeight         = StoreUtil::getImageSetting('category_image_height', 90);
        $thumbnail              = FileUploadUtil::getThumbnailImage($this->category, 'image', ['thumbWidth' => $categoryWidth, 'thumbHeight' => $categoryHeight, 'cssClass' => 'img-thumbnail']);
        
        $file                   = UsniAdaptor::getAlias('@themes/' . $theme . '/views/productCategories/list') . '.php';
        return $this->getView()->renderPhpFile($file, ['title' => $this->category->name,
                                                       'thumbnail' => $thumbnail,
                                                       'description' => $this->category->description,
                                                       'listOrGrid' => $listOrGrid->render(),
                                                       'showItemsPerPage' => $show->render(),
                                                       'sortBy' => $sortBy->render(),
                                                       'productListView' => $productList
                                                      ]);
    }
    
    /**
     * @inheritdoc
     */
    protected function getLeftColumnContent()
    {
        $menuView  = new CategoryMenuView($this->category);
        $content   = $menuView->render();
        return \usni\library\components\UiHtml::tag('div', $content, ['id' => 'catgeory-sidebar-menu']);
    }
}