<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views\front;

use usni\library\views\UiView;
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use yii\web\View;
use productCategories\utils\ProductCategoryUtil;
use frontend\utils\FrontUtil;
use usni\library\utils\ArrayUtil;
/**
 * SortByView class file.
 * @package products\views\front
 */
class SortByView extends UiView
{
    /**
     * Store pjax container id.
     * @var string
     */
    protected $pjaxId;
    
    /**
     * @var string 
     */
    protected $url;
    
    /**
     * Request params
     * @var array 
     */
    protected $params;

    /**
     * Class constructor.
     * @param string $pjaxId
     */
    public function __construct($pjaxId)
    {
        $this->pjaxId   = $pjaxId;
    }

    /**
     * Return content to show list/grid.
     * @return string
     */
    protected function renderContent()
    {
        $content  = $this->renderDropDown();
        $theme    = FrontUtil::getThemeName();
        $filePath = UsniAdaptor::getAlias('@themes/' . $theme . '/views/productCategories/_sortby.php');
        return $this->getView()->renderPhpFile($filePath, ['content' => $content, 'id' => 'sortBy']);
    }

    /**
     * Renders sort by dropdown.
     * @return string
     */
    protected function renderDropDown()
    {
        $data       = ProductCategoryUtil::getSortingOptions();
        $selection  = UsniAdaptor::app()->request->get('sort');
        return UiHtml::dropDownList('sortBy', $selection, $data, ['id' => 'sortBy', 'class' => 'form-control']);
    }
    
    /**
     * Set url which serves as a base to which param would be added on change
     * @return void
     */
    protected function resolveUrlAndParams()
    {
        list($route, $params) = UsniAdaptor::app()->request->resolve();
        $sort                 = ArrayUtil::getValue($params, 'sort');
        if($sort != null)
        {
            unset($params['sort']);
        }
        $this->url = UsniAdaptor::createUrl($route, $params);
        $this->params = $params;
    }

    /**
     * Registers script for the addon list page.
     * @return void
     */
    protected function registerScripts()
    {
        $this->resolveUrlAndParams();
        $operator   = $this->resolveUrlOperator();
        $script     = "$('#sortBy').on('change', function(e){
                            var url = '{$this->url}' + '{$operator}' + 'sort=' + $(this).val();
                            window.location.href = url;
                       })";
        $this->getView()->registerJs($script, View::POS_END);
    }
    
    /**
     * Resolve url operator
     * @return string
     */
    protected function resolveUrlOperator()
    {
        if(empty($this->params))
        {
            return '?';
        }
        return '&';
    }
}