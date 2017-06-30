<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\widgets;

use usni\UsniAdaptor;
use yii\web\View;
use usni\library\utils\ArrayUtil;
/**
 * ToolbarWidget class file.
 *
 * @package productCategories\widgets
 */
class ToolbarWidget extends \yii\bootstrap\Widget
{
    /**
     * @var string 
     */
    public $sortByUrl;
    
    /**
     * @var array 
     */
    public $sortByParams;
    
    /**
     * @var string 
     */
    public $showItemPerPageUrl;
    
    /**
     * @var string 
     */
    public $showItemPerPageParams;

    /**
     * @var string layout for the toolbar 
     */
    public $layout = "{listorgrid}\n{sort}\n{itemsPerPage}";

    /**
     * inheritdoc
     */
    public function run()
    {
        $content = preg_replace_callback("/{\\w+}/", function ($matches) {
                $content = $this->renderSection($matches[0]);

                return $content === false ? $matches[0] : $content;
            }, $this->layout);
        // List or grid view.
        $this->registerShowListOrGridScripts();
        $this->registerSortByScripts();
        $this->registerShowItemPerPageScripts();
        return $content;
    }
    
    /**
     * Renders a section of the specified name.
     * If the named section is not supported, false will be returned.
     * @param string $name the section name, e.g., `{headerLink}`, `{listItems}`.
     * @return string|boolean the rendering result of the section, or false if the named section is not supported.
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{listorgrid}':
                return $this->renderListOrGrid();
            case '{itemsPerPage}':
                return $this->renderItemsPerPage();
            case '{sort}':
                return $this->renderSortBy();
            default:
                return false;
        }
    }
    
    /**
     * Renders list or grid view
     * @return string
     */
    public function renderListOrGrid()
    {
        return $this->getView()->render('//common/_listorgrid');
    }
    
    /**
     * Renders sort by dropdown
     * @return string
     */
    public function renderSortBy()
    {
        return $this->getView()->render('//common/_sortby');
    }
    
    /**
     * Renders items per page dropdown
     * @return string
     */
    public function renderItemsPerPage()
    {
        return $this->getView()->render('//common/_showItemsPerPage');
    }
    
    /**
     * Set url which serves as a base to which param would be added on change
     * @return void
     */
    protected function resolveShowItemPerPageUrlAndParams()
    {
        list($route, $params) = UsniAdaptor::app()->request->resolve();
        $itemsPerPage         = ArrayUtil::getValue($params, 'showItemsPerPage');
        if($itemsPerPage != null)
        {
            unset($params['showItemsPerPage']);
        }
        $this->showItemPerPageUrl       = UsniAdaptor::createUrl($route, $params);
        $this->showItemPerPageParams    = $params;
    }
    
    /**
     * Set url which serves as a base to which param would be added on change
     * @return void
     */
    public function resolveSortByUrlAndParams()
    {
        list($route, $params) = UsniAdaptor::app()->request->resolve();
        $sort                 = ArrayUtil::getValue($params, 'sort');
        if($sort != null)
        {
            unset($params['sort']);
        }
        $this->sortByUrl    = UsniAdaptor::createUrl($route, $params);
        $this->sortByParams = $params;
    }
    
    /**
     * Resolve url operator
     * @return string
     */
    protected function resolveSortByUrlOperator()
    {
        if(empty($this->sortByParams))
        {
            return '?';
        }
        return '&';
    }
    
    /**
     * Resolve url operator
     * @return string
     */
    protected function resolveShowItemPerPageUrlOperator()
    {
        if(empty($this->showItemPerPageParams))
        {
            return '?';
        }
        return '&';
    }
    
    /**
     * Registers script for the list product.
     * @return void
     */
    public function registerShowListOrGridScripts()
    {
        $script     = " $('#list-view').on('click', function(){
                                $('#content .row .product-layout').attr('class', 'product-layout product-list col-xs-12');
                                localStorage.setItem('display', 'list');
                        });
                        $('#grid-view').on('click', function(){
                                cols = $('#column-right, #column-left').length;
                                if (cols == 2) {
                                    $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');
                                } else if (cols == 1) {
                                    $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');
                                } else {
                                    $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12');
                                }
                                localStorage.setItem('display', 'grid');
                        });
                        if (localStorage.getItem('display') == 'list') {
                            $('#list-view').trigger('click');
                        } else {
                            $('#grid-view').trigger('click');
                        }
                       ";
        $this->getView()->registerJs($script, View::POS_END);
    }
    
    /**
     * Registers script for the addon list page.
     * @return void
     */
    protected function registerSortByScripts()
    {
        $this->resolveSortByUrlAndParams();
        $operator   = $this->resolveSortByUrlOperator();
        $script     = "$('#sortBy').on('change', function(e){
                            var url = '{$this->sortByUrl}' + '{$operator}' + 'sort=' + $(this).val();
                            window.location.href = url;
                       })";
        $this->getView()->registerJs($script, View::POS_END);
    }
    
    /**
     * Registers script for the list product.
     * @return void
     */
    protected function registerShowItemPerPageScripts()
    {
        $this->resolveShowItemPerPageUrlAndParams();
        $operator   = $this->resolveShowItemPerPageUrlOperator();
        $script     = "$('#showItemsPerPage').on('change', function(e){
                                                                var url = '{$this->showItemPerPageUrl}' + '{$operator}' + 'showItemsPerPage=' + $(this).val();
                                                                window.location.href = url;
                       })";
        $this->getView()->registerJs($script, View::POS_END);
    }
}