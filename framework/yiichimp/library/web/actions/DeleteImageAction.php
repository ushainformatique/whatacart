<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web\actions;

use usni\UsniAdaptor;
use usni\library\utils\FileUploadUtil;
/**
 * Standalone action for performing delete image functionality from update screen in the admin panel.
 *
 * @package usni\library\web\actions
 */
class DeleteImageAction extends \yii\base\Action
{
    /**
     * @var string model class name 
     */
    public $modelClass;
    
    /**
     * @var string image field attribute 
     */
    public $attribute;
    
    /**
     * @var int image width 
     */
    public $imageWidth = 150;
    
    /**
     * @var int image height 
     */
    public $imageHeight = 150;
        
    /**
     * Runs the action
     * @return string
     */
    public function run()
    {
        if(UsniAdaptor::app()->request->isAjax)
        {
            $id         = $_GET['id'];
            $modelClass         = $this->modelClass;
            $model              = $modelClass::findOne($id);
            $model->scenario    = 'deleteimage';
            FileUploadUtil::deleteImage($model, $this->attribute, $this->imageWidth, $this->imageHeight);
            $model->{$this->attribute} = null;
            $model->save();   
        }
    }
}
