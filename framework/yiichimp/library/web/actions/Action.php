<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web\actions;

use yii\base\InvalidConfigException;
use yii\db\ActiveRecordInterface;
use yii\web\NotFoundHttpException;
use usni\library\utils\StringUtil;
use yii\base\Model;
use usni\library\utils\ArrayUtil;

/**
 * Action is the base class for action classes .
 *
 * @package usni\library\web\actions
 */
class Action extends \yii\base\Action
{
    /**
     * @var string the scenario to be assigned to the model before it is validated and updated.
     */
    public $scenario = Model::SCENARIO_DEFAULT;
    /**
     * @var string class name of the model which will be handled by this action.
     * The model class must implement [[ActiveRecordInterface]].
     * This property must be set.
     */
    public $modelClass;
    /**
     * @var callable a PHP callable that will be called when running an action to determine
     * if the current user has the permission to execute the action. If not set, the access
     * check will not be performed. The signature of the callable should be as follows,
     *
     * ```php
     * function ($action, $model = null) {
     *     // $model is the requested model instance.
     *     // If null, it means no specific model (e.g. IndexAction)
     * }
     * ```
     * @see yii\rest\Action
     */
    public $checkAccess;
    
    /**
     * @var array the configuration for the manager which would perform all the business logic and database interaction
     * related to the model. If class property is not set the default base manager would be used.
     */
    public $managerConfig;
    
    /**
     * @var string the view name 
     */
    public $viewFile;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->modelClass === null) 
        {
            throw new InvalidConfigException(get_class($this) . '::$modelClass must be set.');
        }
    }

    /**
     * Returns the data model based on the primary key given.
     * If the data model is not found, a 404 HTTP exception will be raised.
     * @param string $id the ID of the model to be loaded. If the model has a composite primary key,
     * the ID must be a string of the primary key values separated by commas.
     * The order of the primary key values should follow that returned by the `primaryKey()` method
     * of the model.
     * @return ActiveRecordInterface the model found
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        /* @var $modelClass ActiveRecordInterface */
        $modelClass = $this->modelClass;
        $keys = $modelClass::primaryKey();
        if (count($keys) > 1) 
        {
            $values = explode(',', $id);
            if (count($keys) === count($values)) 
            {
                $model = $modelClass::findOne(array_combine($keys, $values));
            }
        } 
        elseif ($id !== null) 
        {
            $model = $modelClass::findOne($id);
        }

        if (isset($model)) 
        {
            return $model;
        } 
        else 
        {
            throw new NotFoundHttpException("Object not found: $id");
        }
    }
    
    /**
     * Get manager class name
     * @return string
     */
    public function getManagerClassName()
    {
        $class = get_class($this->controller->module);
        if (($pos = strrpos($class, '\\')) !== false) 
        {
            $managerClass = substr($class, 0, $pos) . '\\business\\Manager';
            if(!class_exists($managerClass))
            {
                $managerClass = '\usni\library\business\Manager';
            }
            return $managerClass;
        }
        return null;
    }
    
    /**
     * Get business manager instance 
     * @return instance of \usni\library\web\business\Manager
     */
    public function getManagerInstance()
    {
        //Derive manager and call the function
        $managerConfig  = $this->managerConfig;
        $managerClass   = ArrayUtil::remove($managerConfig, 'class', $this->getManagerClassName());
        return new $managerClass($managerConfig);
    }
    
    /**
     * Get model base name
     * @return string
     */
    public function getModelBaseName()
    {
        return StringUtil::basename($this->modelClass);
    }
}