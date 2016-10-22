<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace frontend\views\common;

use frontend\utils\FrontUtil;
use usni\UsniAdaptor;
use products\models\Product;
use products\views\front\SortByView;
use products\views\front\ShowItemsPerPageView;
use products\views\front\ShowListOrGridView;
/**
 * SearchResultsView class file.
 *
 * @package frontend\views\common
 */
class SearchResultsView extends \frontend\views\FrontPageView
{
    /**
     * Model associated with the view
     * @var SearchForm 
     */
    public $model;

    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $theme                  = FrontUtil::getThemeName();
        $searchListView         = new SearchResultsListView(['model' => new Product(), 'searchFormModel' => $this->model]);
        $searchList             = $searchListView->render();
        $sortBy                 = new SortByView($searchListView->pjaxContainerId);
        $show                   = new ShowItemsPerPageView($searchListView->pjaxContainerId);
        $listOrGrid             = new ShowListOrGridView($searchListView->pjaxContainerId);        
        $file                   = UsniAdaptor::getAlias('@themes/' . $theme . '/views/products/searchlist') . '.php';
        return $this->getView()->renderPhpFile($file, ['title' => $this->getTitle(),
                                                       'listOrGrid' => $listOrGrid->render(),
                                                       'showItemsPerPage' => $show->render(),
                                                       'sortBy' => $sortBy->render(),
                                                       'productListView' => $searchList,
                                                      ]);
    }
    
    /**
     * Get title
     * @return string
     */
    protected function getTitle()
    {
        return UsniAdaptor::t('application', 'Search Results') . ' - ' . $this->model->keyword;
    }


    /**
     * Get search form
     * @return string
     */
    protected function getSearchForm()
    {
        $theme                  = FrontUtil::getThemeName();
        $file                   = UsniAdaptor::getAlias('@themes/' . $theme . '/views/products/searchForm') . '.php';
        return $this->getView()->renderPhpFile($file, ['model' => $this->model]);
    }
    
    /**
     * @inheritdoc
     */
    protected function getLeftColumnContent()
    {
        return $this->getSearchForm();
    }
}