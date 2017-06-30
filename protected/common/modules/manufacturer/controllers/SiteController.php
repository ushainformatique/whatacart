<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\manufacturer\controllers;

use frontend\controllers\BaseController;
use usni\UsniAdaptor;
use frontend\models\SearchForm;
use common\modules\manufacturer\models\Manufacturer;
use common\modules\manufacturer\dto\ManufacturerListViewDTO;
use frontend\business\SearchManager;
/**
 * SiteController class file.
 * 
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
        if($queryParams != null)
        {
            $model->attributes = $queryParams;
            if($model->validate())
            {
                $listViewDTO    = new ManufacturerListViewDTO();
                $listViewDTO->setSearchModel($model);
                $listViewDTO->setSortingOption(UsniAdaptor::app()->request->get('sort'));
                $listViewDTO->setPageSize(UsniAdaptor::app()->request->get('showItemsPerPage'));
                $dataCategoryId = UsniAdaptor::app()->storeManager->selectedStore['data_category_id'];
                $listViewDTO->setDataCategoryId($dataCategoryId);
                $manList        = Manufacturer::find()->asArray()->all();
                $listViewDTO->setManList($manList);
                $manufacturer   = Manufacturer::find()->where('id = :id', [':id' => $model->manufacturerId])->asArray()->one();
                $listViewDTO->setManufacturer($manufacturer);
                $dp             = SearchManager::getInstance()->getDataProvider($listViewDTO);
                $listViewDTO->setDataprovider($dp);
                return $this->render('/front/searchview', ['listViewDTO' => $listViewDTO]);
            }
            else
            {
                throw new \yii\base\InvalidParamException(UsniAdaptor::t('application', 'Invalid search param'));
            }
        }        
    }
}
