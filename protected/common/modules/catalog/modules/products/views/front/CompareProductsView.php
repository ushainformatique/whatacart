<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views\front;

use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use products\models\Product;
use products\views\front\CompareProductsListView;
use frontend\utils\FrontUtil;
use frontend\views\FrontPageView;
/**
 * CompareProductsView class file
 * @package products\views
 */
class CompareProductsView extends FrontPageView
{   
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $detail    = $this->renderCompareProductContent();
        $theme     = FrontUtil::getThemeName();
        $file      = UsniAdaptor::getAlias('@themes/' . $theme . '/views/products/_compareproduct') . '.php';
        return $this->getView()->renderPhpFile($file, ['detail' => $detail]);
    }
    
    /**
     * Render continue button.
     * @return string
     */
    protected static function renderContinueButton()
    {
       $label       = UsniAdaptor::t('application', 'Continue');
       $buttonName  = UiHtml::a($label,UsniAdaptor::app()->getHomeUrl(), ['class' => 'btn btn-default']);
       return "<div class='buttons'>            
                <div class='pull-right'>  
                $buttonName
                </div>
           </div>";
    }
    
    /**
     * Renders compare products content
     * @param View $view
     * @return string
     */
    public function renderCompareProductContent()
    {
        $listInstance   = new CompareProductsListView(['model' => new Product()]);
        $listContent    = $listInstance->render();
        return $listContent;
    }
}
