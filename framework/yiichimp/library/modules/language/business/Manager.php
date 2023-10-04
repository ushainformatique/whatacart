<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\language\business;

use usni\UsniAdaptor;
use usni\library\utils\FileUploadUtil;
use usni\library\managers\UploadInstanceManager;
use usni\library\modules\language\models\Language;
use usni\library\utils\ArrayUtil;
/**
 * Manager class file.
 * 
 * @package usni\library\modules\language\business
 */
class Manager extends \usni\library\business\Manager
{   
    /**
     * @inheritdoc
     */
    public function beforeModelSave($model)
    {
        if(parent::beforeModelSave($model))
        {
            $config = [
                            'model'             => $model,
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
        return false;
    }

    /**
     * @inheritdoc
     */
    public function afterModelSave($model)
    {
        if($model->image != null)
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
     * inheritdoc
     */
    public function beforeAssigningPostData($model)
    {
        $model->savedImage = $model->image;
    }
    
    /**
     * Get list of languages.
     * @return array
     */
    public function getList()
    {
        $allowedLanguages = Language::find()->where('status = :status', [':status' => Language::STATUS_ACTIVE])->asArray()->all();
        return ArrayUtil::map($allowedLanguages, 'code', 'name');
    }
    
    /**
     * Get translated languages
     * @return array
     */
    public function getTranslatedLanguages()
    {
        $allowedLanguages = $this->getList();
        unset($allowedLanguages['en-US']);
        if(!empty($allowedLanguages))
        {
            return array_keys($allowedLanguages);
        }
        return [];
    }
}