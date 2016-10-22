<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\controllers;

use frontend\controllers\BaseController;
use productCategories\views\front\ProductCategoryView;
use frontend\utils\FrontUtil;
use productCategories\models\ProductCategory;
use frontend\components\Breadcrumb;
/**
 * SiteController class file
 * @package productCategories\controllers
 */
class SiteController extends BaseController
{   
    /**
     * Product lists on the basis of category.
     * @param $id int
     * @return null 
     */
    public function actionView($id)
    {
        $productCat         = ProductCategory::findOne($id);
        $breadcrumbView     = new Breadcrumb(['page' => $productCat->name]);
        $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
        $productCategoryView     = new ProductCategoryView($productCat);
        $this->setMetaKeywords($productCat->metakeywords);
        $this->setMetaDescription($productCat->metadescription);
        $content                 = $this->renderInnerContent([$productCategoryView]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content, 'title' => $productCat->name]);
    }
}
