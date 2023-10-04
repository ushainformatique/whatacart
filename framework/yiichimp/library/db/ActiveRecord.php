<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\db;

use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use usni\library\exceptions\MethodNotImplementedException;
use usni\library\utils\ObjectUtil;
/**
 * Base active record class for the application.
 * 
 * @package usni\library\components
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    use \usni\library\traits\ActiveRecordTrait;
    /**
     * Active status constant.
     */
    const STATUS_ACTIVE = 1;
    /**
     * Inactive status constant.
     */
    const STATUS_INACTIVE = 0;
    
    /**
     * Get translated attribute labels.
     * @param string $labels Attribute labels.
     * @return array
     */
    public static function getTranslatedAttributeLabels($labels)
    {
        return ArrayUtil::merge($labels, array( 'created_by'        => UsniAdaptor::t('application','Created By'),
                                                'created_datetime'  => UsniAdaptor::t('application','Created Date Time'),
                                                'modified_by'       => UsniAdaptor::t('application','Modified By'),
                                                'modified_datetime' => UsniAdaptor::t('application','Modified Date Time')));
    }

    /**
     * Get singular or plural label.
     * @return string
     * @throws exception MethodNotImplementedException.
     */
    public static function getLabel($n = 1)
    {
        throw new MethodNotImplementedException('getLabel', get_called_class());
    }

    /**
     * Find record by attribute. This would not work with translated attributes
     * @param string $attribute Attribute name.
     * @param string $value     Attribute value.
     * @return ActiveRecord
     */
    public static function findByAttribute($attribute, $value)
    {
        $modelClass     = get_called_class();
        $condition      = $attribute . "= '" . $value . "'";
        return $modelClass::find()->where($condition)->one();
    }

    /**
     * Get required attributes for the model.
     * @return array
     */
    public function getRequiredAttributes()
    {
        $requiredAttributes = array();
        $attributes         = ArrayUtil::merge($this->attributes(), ObjectUtil::getClassPublicProperties(get_called_class(), true));
        foreach($attributes as $attribute)
        {
            if($this->isAttributeRequired($attribute))
            {
                $requiredAttributes[] = $attribute;
            }
        }
        return $requiredAttributes;
    }

    /**
     * Should created and modified fields be added to the model.
     * @return boolean
     */
    public function shouldAddCreatedAndModifiedFields()
    {
        return true;
    }

    /**
     * Get model configuration
     * @return array
     */
    public function getModelConfig()
    {
        $modelConfigFilePath = UsniAdaptor::getAlias('@common/config/modelConfig.php');
        $config    = [];
        $shortName = strtolower(UsniAdaptor::getObjectClassName($this));
        $namespace = ObjectUtil::getClassNamespace(get_class($this));
        $alias     = str_replace('\\', '/', $namespace);
        $path      = UsniAdaptor::getAlias($alias);
        if(file_exists($path . '/config/' . $shortName . '.php'))
        {
            $config = require($path . '/config/' . $shortName . '.php');
        }
        elseif (file_exists($modelConfigFilePath))
        {
            $config = require($modelConfigFilePath);
            $className  = get_class($this);
            $classConfig = ArrayUtil::getValue($config, $className, []);
            return $classConfig;
        }
        return $config;
    }
    
    /**
     * Check if extended config exists for the model
     * @return boolean
     */
    public function checkIfExtendedConfigExists()
    {
        $extendedModelConfig = UsniAdaptor::app()->extendedModelsConfig;
        $calledClass         = get_class($this);
        if(is_array($extendedModelConfig) && ArrayUtil::getValue($extendedModelConfig, $calledClass) != null)
        {
            return true;
        }
        return false;
    }
    
    /**
     * Get extended config class instance
     * @return \usni\library\components\modelConfigClass
     */
    public function getExtendedConfigClassInstance()
    {
        $calledClass            = get_class($this);
        $extendedModelConfig    = UsniAdaptor::app()->extendedModelsConfig;
        $modelConfigClass       = $extendedModelConfig[$calledClass];
        $configClassInstance    = new $modelConfigClass($this);
        return $configClassInstance;
    }
    
    /**
     * Get record by name.
     * @param string $name
     * @param string $language
     * @return Model
     */
    public static function findByName($name, $language = null)
    {
        $class          = get_called_class();
        $activeQuery    = $class::find();
        return $activeQuery->where('name = :name', [':name' => $name])->one();
    }
    
    /**
     * Get logged in user id
     * @return int
     */
    public function getUserId()
    {
        return UsniAdaptor::app()->user->getId();
    }
}