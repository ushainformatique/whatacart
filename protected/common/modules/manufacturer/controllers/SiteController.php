<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\manufacturer\controllers;

use frontend\controllers\BaseController;
use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
use frontend\models\SearchForm;
use common\modules\manufacturer\views\front\ProductManufacturerView;
use frontend\components\Breadcrumb;
use common\modules\manufacturer\models\Manufacturer;
/**
 * SiteController class file.
 * @package common\modules\manufacturer\controllers
 */
class SiteController extends BaseController
{
    /**
     * Render List.
     * @return string
     */
    public function actionList()
    {
        $model          = new SearchForm();
        $queryParams    = UsniAdaptor::app()->getRequest()->getQueryParams();
        $manufacturer   = [];
        if($queryParams != null)
        {
            $model->attributes = $queryParams;
            $tableName  = Manufacturer::tableName();
            $query      = (new \yii\db\Query());
            $manufacturer     = $query->select('*')->from($tableName)->where('id = :id', [':id' => $model->manufacturerId])->one();
            $breadcrumbView = new Breadcrumb(['page' => $manufacturer['name']]);
            $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
            $this->getView()->params['title'] = $manufacturer['name']; 
        }
        $searchView     = new ProductManufacturerView(['model' => $model, 'manufacturer' => $manufacturer]);
        $content        = $this->renderInnerContent([$searchView]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }
}
