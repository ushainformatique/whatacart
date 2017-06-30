<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\business;

use usni\UsniAdaptor;
use usni\library\utils\FileUploadUtil;
use usni\library\managers\UploadInstanceManager;
/**
 * Manager class file.
 * 
 * @package common\modules\manufacturer\business
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
}