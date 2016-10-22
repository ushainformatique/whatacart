<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views\front;

use usni\library\views\UiView;
use usni\UsniAdaptor;
use yii\web\View;
use usni\library\components\UiHtml;
use productCategories\utils\ProductCategoryUtil;
use frontend\utils\FrontUtil;
use usni\library\utils\ArrayUtil;
use common\modules\stores\utils\StoreUtil;
/**
 * ShowItemsPerPageView class file.
 *
 * @package products\views\front
 */
class ShowItemsPerPageView extends UiView
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
     * @return string
     */
    protected function renderContent()
    {
        $content  = $this->renderDropDown();
        $theme    = FrontUtil::getThemeName();
        $filePath = UsniAdaptor::getAlias('@themes/' . $theme . '/views/productCategories/_showItemsPerPage.php');
        return $this->getView()->renderPhpFile($filePath, ['content' => $content, 'id' => 'showItemsPerPage']);
    }

    /**
     * Renders sort by dropdown.
     * @return string
     */
    protected function renderDropDown()
    {
        $data       = ProductCategoryUtil::getItemsPerPageOptions();
        $selection  = UsniAdaptor::app()->request->get('showItemsPerPage');
        if($selection == null)
        {
            $selection = StoreUtil::getSettingValue('catalog_items_per_page');
        }
        return UiHtml::dropDownList('showItemsPerPage', $selection, $data, ['id' => 'showItemsPerPage', 'class' => 'form-control']);
    }
    
    /**
     * Set url which serves as a base to which param would be added on change
     * @return void
     */
    protected function resolveUrlAndParams()
    {
        list($route, $params) = UsniAdaptor::app()->request->resolve();
        $itemsPerPage         = ArrayUtil::getValue($params, 'showItemsPerPage');
        if($itemsPerPage != null)
        {
            unset($params['showItemsPerPage']);
        }
        $this->url = UsniAdaptor::createUrl($route, $params);
        $this->params = $params;
    }

    /**
     * Registers script for the list product.
     * @return void
     */
    protected function registerScripts()
    {
        $this->resolveUrlAndParams();
        $operator   = $this->resolveUrlOperator();
        $script     = "$('#showItemsPerPage').on('change', function(e){
                                                                var url = '{$this->url}' + '{$operator}' + 'showItemsPerPage=' + $(this).val();
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
