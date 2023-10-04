<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web\actions;

use usni\UsniAdaptor;
use usni\library\dto\GridViewDTO;
use yii\base\Model;
use usni\library\utils\ArrayUtil;
/**
 * IndexAction class file. This would handle displaying list of models.
 *
 * @package usni\library\web\actions
 */
class IndexAction extends Action
{
    /**
     * @var string class name of the [[GridViewDTO]] which will be used in this action.
     * This property must be set.
     */
    public $dtoClass;
    
    /**
     * @var array configuration for the search model
     * This property must be set.
     */
    public $searchConfig;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        if($this->dtoClass == null)
        {
            $this->dtoClass = GridViewDTO::className();
        }
    }
    
    /**
     * Runs the action
     * @return string
     */
    public function run()
    {
        /* @var $gridViewDTO \usni\library\dto\GridViewDTO */
        $gridViewDTO    = new $this->dtoClass();
        $gridViewDTO->setQueryParams(UsniAdaptor::app()->request->queryParams);
        $gridViewDTO->setSearchModel($this->getSearchModelInstance());
        $manager        = $this->getManagerInstance();
        $manager->processList($gridViewDTO);
        if($this->viewFile != null)
        {
            return $this->controller->render($this->viewFile, ['gridViewDTO' => $gridViewDTO]);
        }
        return $this->controller->render('index', ['gridViewDTO' => $gridViewDTO]);
    }
    
    /**
     * Get search model instance 
     * @return Model
     */
    public function getSearchModelInstance()
    {
        //Derive manager and call the function
        $searchConfig   = $this->searchConfig;
        $searchClass    = ArrayUtil::remove($searchConfig, 'class', $this->getSearchModelClassName());
        return new $searchClass($searchConfig);
    }
    
    /**
     * Get search model class name
     * @return string
     */
    public function getSearchModelClassName()
    {
        return $this->modelClass . 'Search' ;
    }
}