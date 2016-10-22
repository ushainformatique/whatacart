<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\language\controllers;

use common\modules\localization\controllers\LocalizationController;
use common\modules\localization\modules\language\models\Language;
use usni\library\utils\FileUploadUtil;
use yii\db\ActiveRecord;
use usni\UsniAdaptor;
use usni\library\managers\UploadInstanceManager;
use common\modules\localization\modules\language\utils\LanguageUtil;
/**
 * DefaultController class file
 * 
 * @package common\modules\localization\modules\language\controllers
 */
class DefaultController extends LocalizationController
{
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Language::className();
    }
    
    /**
     * @inheritdoc
     */
    protected function beforeAssigningPostData($language)
    {
        assert($language instanceof ActiveRecord);
        $language->savedImage = $language->image;
    }

    /**
     * @inheritdoc
     */
    protected function beforeModelSave($language)
    {
        $config = [
                        'model'             => $language,
                        'attribute'         => 'image',
                        'uploadInstanceAttribute' => 'uploadInstance',
                        'type'              => 'image',
                        'savedAttribute'    => 'savedImage',
                        'fileMissingError'  => UsniAdaptor::t('application', 'Please upload image'),
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
    protected function afterModelSave($language)
    {
        if($language->image != null)
        {
            $config = [
                            'model'             => $language, 
                            'attribute'         => 'image', 
                            'uploadInstance'    => $language->uploadInstance, 
                            'savedFile'         => $language->savedImage
                      ];
            FileUploadUtil::save('image', $config);
        }
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . Language::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . Language::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . Language::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . Language::getLabel(2)
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function deleteModel($model)
    {
        $isAllowedToDelete = LanguageUtil::checkIfAllowedToDelete($model);
        if(!$isAllowedToDelete)
        {
            $message = UsniAdaptor::t('languageflash', 'The application language could not be deleted.');
            UsniAdaptor::app()->getSession()->setFlash('deleteFailed', $message);
            return false;
        }
        return parent::deleteModel($model);
    }
}