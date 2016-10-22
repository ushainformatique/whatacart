<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\controllers;

use common\modules\catalog\controllers\BaseController;
use productCategories\models\ProductCategory;
use yii\db\ActiveRecord;
use usni\library\utils\FileUploadUtil;
use usni\library\utils\TranslationUtil;
use usni\UsniAdaptor;
use productCategories\utils\ProductCategoryUtil;
use usni\library\managers\UploadInstanceManager;
/**
 * DefaultController class file
 *
 * @package productCategories\controllers
 */
class DefaultController extends BaseController
{
    /**
     * @inheritdoc
     */
    protected function beforeAssigningPostData($model)
    {
        assert($model instanceof ActiveRecord);
        $model->savedImage = $model->image;
    }

    /**
     * @inheritdoc
     */
    protected function beforeModelSave($model)
    {
        $config = [
                        'model'             => $model,
                        'attribute'         => 'image',
                        'uploadInstanceAttribute' => 'uploadInstance',
                        'type'              => 'image',
                        'savedAttribute'    => 'savedImage',
                        'fileMissingError'  => UsniAdaptor::t('application', 'Please upload image'),
                        'required'          => true
                  ];
        $uploadInstanceManager = new UploadInstanceManager($config);
        $result = $uploadInstanceManager->processUploadInstance();
        if($result === false)
        {
            return false;
        }
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function afterModelSave($model)
    {
        if($this->action->id == 'create')
        {
            TranslationUtil::saveTranslatedModels($model);
        }
        if($model->image != '')
        {
            $config = [
                        'model'             => $model, 
                        'attribute'         => 'image', 
                        'uploadInstance'    => $model->uploadInstance,
                        'savedFile'         => $model->savedImage
                      ];
            FileUploadUtil::save('image', $config);
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return ProductCategory::className();
    }
    
    /**
     * @inheritdoc
     */
    public function actionView($id)
    {
        $categoryIdArray    =  [];
        $records            = ProductCategoryUtil::getStoreProductCategories();
        foreach ($records as $record)
        {
            $categoryIdArray[] = $record['id'];
        }
        if(!in_array($_GET['id'], $categoryIdArray))
        {
            throw new \yii\web\NotFoundHttpException();
        }
        return parent::actionView($id);
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . ProductCategory::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . ProductCategory::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . ProductCategory::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . ProductCategory::getLabel(2)
               ];
    }
}