<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\db;

use yii\base\Component;
use usni\library\db\TranslatableActiveRecord;
use usni\library\modules\notification\models\NotificationTemplate;
use usni\library\exceptions\MethodNotImplementedException;
use usni\library\modules\language\business\Manager as LanguageBusinessManager;
use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
/**
 * DataManager is the abstract class for data management in the application.
 * 
 * @package usni\library\db
 */
abstract class DataManager extends Component
{
    /**
     * Get instance of the class
     * @param array $config
     * @return object the created object
     */
    public static function getInstance($config = [])
    {
        $class = get_called_class();
        return new $class($config);
    }
    
    /**
     * Loads default data.
     * @return boolean
     */
    public function loadDefaultData()
    {
        $this->loadDefaultDependentData();
        return $this->processAndInsertData('default');
    }
    
    /**
     * Loads demo data.
     * @return boolean
     */
    public function loadDemoData()
    {
        $this->loadDemoDependentData();
        return $this->processAndInsertData('demo');
    }
    
    /**
     * Process and insert data.
     * @param string $type
     * @return void
     */
    public function processAndInsertData($type)
    {
        $dataSet = $this->getDataSetByType($type);
        $this->processDataSetAndSaveModel($dataSet, $type);
        return true;
    }
    
    /**
     * Get data set by type.
     * @param string $type
     * @return array
     * @throws \yii\base\NotSupportedException
     */
    public function getDataSetByType($type)
    {
        if($type == 'default')
        {
            $dataSet = $this->getDefaultDataSet();
        }
        elseif($type == 'demo')
        {
            $dataSet = $this->getDefaultDemoDataSet();
        }
        else
        {
            throw new \yii\base\NotSupportedException();
        }
        return $dataSet;
    }

    /**
     * Process data set and save model
     * @param array $dataSet
     * @param string $type
     */
    protected function processDataSetAndSaveModel($dataSet, $type)
    {
        if(!empty($dataSet))
        {
            foreach($dataSet as $index => $set)
            {
                $modelClassName = static::getModelClassName();
                $model          = new $modelClassName(['scenario' => 'create']);
                $model->setAttributes($set);
                if(!$model->save())
                {
                    print "<pre>";
                    print_r($model->getErrors());
                    print "</pre>";
                    
                    throw new \usni\library\exceptions\FailedToSaveModelException(get_class($model));
                }
                $this->saveTranslatedModels($model, $dataSet, $index);
            }
        }
    }
    
    /**
     * Save translated models
     * @param TranslatableActiveRecord $model
     * @param array $dataSet
     * @param int $index
     */
    public function saveTranslatedModels($model, $dataSet, $index)
    {
        if($model instanceof TranslatableActiveRecord)
        {
            $installTargetLanguage  = UsniAdaptor::app()->language;
            $translationModel       = $model->getTranslation();
            $class                  = get_class($translationModel);
            $translatedLanguages    = LanguageBusinessManager::getInstance()->getTranslatedLanguages();
            foreach($translatedLanguages as $translatedLanguage)
            {
                UsniAdaptor::app()->language = $translatedLanguage;
                $currentDataSet = $dataSet[$index];
                $trInstance     = new $class;
                foreach($model->translationAttributes as $attribute)
                {
                    if(ArrayUtil::getValue($currentDataSet, $attribute) != null)
                    {
                        $trInstance->$attribute = $currentDataSet[$attribute];
                    }
                }
                $trInstance->language = $translatedLanguage;
                $trInstance->owner_id = $model->id;
                $trInstance->save();
            }
            UsniAdaptor::app()->language = $installTargetLanguage;
        } 
    }
    
    /**
     * Get model class name
     * @return string
     */
    public static function getModelClassName()
    {
        throw new MethodNotImplementedException(__METHOD__, get_called_class());
    }
    
    /**
     * Get default data set.
     * @return array
     */
    public function getDefaultDataSet()
    {
        return [];
    }
    
    /**
     * Get default data set.
     * @return array
     */
    public function getDefaultDemoDataSet()
    {
        return [];
    }
    
    /**
     * Loads default dependent data
     */
    public function loadDefaultDependentData()
    {
        
    }
    
    /**
     * Loads demo dependent data
     */
    public function loadDemoDependentData()
    {
        
    }
    
    /**
     * Get default language.
     * @return string
     */
    public static function getDefaultLanguage()
    {
        return UsniAdaptor::app()->language;
    }
    
    /**
     * Save notification template.
     * @throws FailedToSaveModelException
     */
    public function saveNotificationTemplate()
    {
        $dataSet = $this->getNotificationDataSet();
        if(!empty($dataSet))
        {
            foreach($dataSet as $index => $set)
            {
                $model          = new NotificationTemplate(['scenario' => 'create']);
                $model->setAttributes($set);
                if(!$model->save())
                {
                    throw new \usni\library\exceptions\FailedToSaveModelException(get_class($model));
                }
                $this->saveTranslatedModels($model, $dataSet, $index);
            }
        }
        return true;
    }
    
    /**
     * Get notification data set
     * @return array
     */
    public function getNotificationDataSet()
    {
        return [];
    }
}