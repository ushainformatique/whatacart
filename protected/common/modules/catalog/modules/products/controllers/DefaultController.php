<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\controllers;

use products\models\Product;
use common\modules\catalog\controllers\BaseController;
use usni\library\utils\FileUploadUtil;
use usni\library\utils\TranslationUtil;
use usni\UsniAdaptor;
use products\utils\ProductUtil;
use yii\web\Response;
use usni\library\managers\UploadInstanceManager;
use products\utils\DiscountUtil;
use products\utils\SpecialUtil;
/**
 * Default controller for products module.
 * 
 * @package products\controllers
 */
class DefaultController extends BaseController
{
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Product::className();
    }

    /**
     * @inheritdoc
     */
    protected function beforeAssigningPostData($model)
    {
        $model->savedImage = $model->image;
    }

    /**
     * @inheritdoc
     */
    protected function beforeModelSave($model)
    {
        $isValid    = true;
        $required   = false;
        if($model->scenario == 'create')
        {
            $required = true;
        }
        $config = [
                        'model'             => $model,
                        'attribute'         => 'image',
                        'uploadInstanceAttribute' => 'uploadInstance',
                        'type'              => 'image',
                        'savedAttribute'    => 'savedImage',
                        'fileMissingError'  => UsniAdaptor::t('application', 'Please upload image'),
                        'required'          => $required
                  ];
        $uploadInstanceManager = new UploadInstanceManager($config);
        $result = $uploadInstanceManager->processUploadInstance();
        if($result === false)
        {
            $isValid = false;
        }
        //For discount
        if (isset($_POST['ProductDiscount']) && is_array($_POST['ProductDiscount']))
        {
            $productDiscounts   = $model->discounts = $_POST['ProductDiscount'];
            $isValid            = DiscountUtil::validateDiscounts($productDiscounts, $model);
        }
        //For related product
        if (isset($_POST['Product']['relatedProducts']) && is_array($_POST['Product']['relatedProducts']))
        {
            $model->relatedProducts = $_POST['Product']['relatedProducts'];
        }
        
        //For special
        if (isset($_POST['ProductSpecial']) && is_array($_POST['ProductSpecial']))
        {
            $productSpecials   = $model->specials = $_POST['ProductSpecial'];
            $isValid           = SpecialUtil::validateSpecials($productSpecials, $model);
        }
        //For product images
        if (isset($_POST['ProductImage']) && is_array($_POST['ProductImage']))
        {
            $model->productImageData = $_POST['ProductImage'];
        }
        $imageErrors    = ProductUtil::validateImageUploads($model);
        if(!empty($imageErrors))
        {
            $isValid = false;
        }
        return $isValid;
    }

    /**
     * @inheritdoc
     */
    public function afterModelSave($model)
    {
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
        if($this->action->id == 'create')
        {
            TranslationUtil::saveTranslatedModels($model);
        }
        return true;
    }
    
    /**
     * List the tag names.
     * @param string $query
     * @return json
     */
    public function actionTags($query)
    {
        $items = ProductUtil::getTagItems($query);
        // We know we can use ContentNegotiator filter
        // this way is easier to show you here :)
        UsniAdaptor::app()->response->format = Response::FORMAT_JSON;
        return $items;
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . Product::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . Product::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . Product::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . Product::getLabel(2)
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function actionView($id)
    {
        if(ProductUtil::checkIfProductAllowedToPerformAction($id) == false)
        {
            throw new \yii\web\NotFoundHttpException();
        }
        return parent::actionView($id);
    }
    
    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        if(ProductUtil::checkIfProductAllowedToPerformAction($id) == false)
        {
            throw new \yii\web\NotFoundHttpException();
        }
        return parent::actionUpdate($id);
    }
    
    /**
     * @inheritdoc
     */
    public function actionDelete($id)
    {
        if(ProductUtil::checkIfProductAllowedToPerformAction($id) == false)
        {
            throw new \yii\web\NotFoundHttpException();
        }
        return parent::actionDelete($id);
    }
}
