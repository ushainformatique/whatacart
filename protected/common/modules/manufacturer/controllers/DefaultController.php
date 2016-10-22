<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\controllers;

use usni\library\utils\FileUploadUtil;
use common\modules\manufacturer\models\Manufacturer;
use usni\library\components\UiAdminController;
use yii\db\ActiveRecord;
use usni\UsniAdaptor;
use usni\library\managers\UploadInstanceManager;
/**
 * DefaultController class file
 * @package common\modules\manufacturer\controllers
 */
class DefaultController extends UiAdminController
{
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Manufacturer::className();
    }
    
    /**
     * @inheritdoc
     */
    protected function beforeAssigningPostData($manufacturer)
    {
        assert($manufacturer instanceof ActiveRecord);
        $manufacturer->savedImage = $manufacturer->image;
    }

    /**
     * @inheritdoc
     */
    protected function beforeModelSave($manufacturer)
    {
        $config = [
                        'model'             => $manufacturer,
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
    protected function afterModelSave($manufacturer)
    {
        if($manufacturer->image != null)
        {
            $config = [
                            'model'             => $manufacturer, 
                            'attribute'         => 'image', 
                            'uploadInstance'    => $manufacturer->uploadInstance, 
                            'savedFile'         => $manufacturer->savedImage
                      ];
            FileUploadUtil::save('image', $config);
        }
        return true;
    }
    
    /**
     * Force delete a model
     * @param string $name
     * @return void
     */
    public function actionForceDelete($name)
    {
        $modelClassName             = $this->resolveModelClassName();
        $translatedModelClassName   = $this->resolveModelClassName() . 'Translated';
        $data = $modelClassName::find()->where('name = :alias', [':alias' => $name])->one();
        if(!empty($data))
        {
           $modelClassName::deleteAll('alias = :alias', [':alias' => $name]);
           $translatedModelClassName::deleteAll('owner_id = :Oid', [':Oid' => $data->id]);
        }
        $this->redirect(Url::to($this->getBreadCrumbManageUrl(), true));
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . Manufacturer::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . Manufacturer::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . Manufacturer::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . Manufacturer::getLabel(2)
               ];
    }
}
?>