<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\widgets;

use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use usni\library\utils\Html;
use usni\library\extensions\select2\ESelect2;
use yii\helpers\Url;
use usni\library\db\ActiveRecord;
/**
 * Renders the browse dropdown on detail or edit view
 *
 * @package usni\library\widgets
 */
class BrowseDropdown extends \yii\bootstrap\Widget
{
    /**
     * @var boolean Flag to check if permission has to be checked or not 
     */
    public $usePermission = false;
    
    /**
     * Permission to be checked for data displayed to user for browse
     * @var string 
     */
    public $permission;
    
    /**
     * Attribute which would be displayed as text in the dropdown
     * @var string 
     */
    public $textAttribute = 'name';
    
    /**
     * Data for the browse dropdown
     * @var array 
     */
    public $data;
    
    /**
     * Current model which is being displayed. 
     * @var ActiveRecord|Array 
     */
    public $model;
    
    /**
     * Layout for the browse dropdown
     * @var string 
     */
    public $layout = '<div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                {label}
                                <div class="col-sm-10">
                                    {field}
                                </div>
                            </div>
                        </div>
                      </div>
                      ';
    
    /**
     * Label for the dropdown field
     * @var string 
     */
    public $label;
    
    /**
     * Label options for the dropdown field
     * @var string 
     */
    public $labelOptions = ['class' => 'control-label col-sm-2 text-right'];
    
    /**
     * inheritdoc
     */
    public function run()
    {
        if($this->usePermission == null)
        {
            $behaviorsData = $this->getView()->context->behaviors();
            if(array_key_exists('access', $behaviorsData))
            {
                $this->usePermission = true;
            }
            else
            {
                $this->usePermission = false;
            }
        }
        $this->filterBrowseData();
        if(empty($this->data))
        {
            return null;
        }
        $content = preg_replace_callback("/{\\w+}/", function ($matches) {
                $content = $this->renderSection($matches[0]);

                return $content === false ? $matches[0] : $content;
            }, $this->layout);
        $this->registerScripts();
        return $content;
    }
    
    /**
     * Renders a section of the specified name.
     * If the named section is not supported, false will be returned.
     * @param string $name the section name, e.g., `{label}`, `{field}`.
     * @return string|boolean the rendering result of the section, or false if the named section is not supported.
     */
    public function renderSection($name)
    {
        switch ($name) 
        {
            case '{label}':
                return $this->renderLabel();
            case '{field}':
                return $this->renderField();
            default:
                return false;
        }
    }
    
    /**
     * Renders the label element.
     * @return string the rendered label element
     */
    public function renderLabel()
    {
        if(empty($this->label))
        {
            $this->label = UsniAdaptor::t('application', 'Browse');
        }
        return Html::label($this->label, null, $this->labelOptions);
    }
    
    /**
     * Renders the field element.
     * @return string the rendered field element
     */
    public function renderField()
    {
        return ESelect2::widget(['data'         => $this->data,
                             'select2Options'   => [],
                             'options'          => ['placeholder' => Html::getDefaultPrompt()],
                             'name'             => 'browse',
                             'id'               => 'browsemodels'
                           ]);
    }
    
    /**
     * Filter browse dropdown data
     * @return array
     */
    public function filterBrowseData()
    {
        $model  = $this->model;
         /*
          * @var boolean Check if user can access others record or not
          * If true, only models created by logged in user is displayed else all models except current model would be displayed
          */
        $canAccessOtherRecords = $this->canAccessOthersRecord($this->permission);
        $models          = $this->data;
        $filteredModels  = array();
        foreach($models as $record)
        {
            if($canAccessOtherRecords === false && isset($model['created_by']))
            {
                if($record['id'] != $model['id'] && $record['created_by'] == $model['created_by'])
                {
                    $filteredModels[] = $record;
                }
            }
            else
            {
                if($record['id'] != $model['id'])
                {
                    $filteredModels[] = $record;
                }
            }
        }
        $this->data = $this->prepareFilteredModelsForDisplay($filteredModels);
    }
    
    /**
     * Prepare filtered models for display
     * @param array $filteredModels
     * @return array
     */
    public function prepareFilteredModelsForDisplay($filteredModels)
    {
        return ArrayUtil::map($filteredModels, 'id', $this->textAttribute);
    }
    
    /**
     * If user can access other records. Thus if permission for view others
     * is true, this is true because user can see all the models. If only view permission is there
     * than this is false as user can see its own records
     * @return boolean
     */
    public function canAccessOthersRecord()
    {
        if($this->usePermission === false)
        {
            return true;
        }
        if(UsniAdaptor::app()->user->can($this->permission))
        {
            return true;
        }
        return false;
    }
    
    /**
     * Register scripts
     */
    public function registerScripts()
    {
        $url        = Url::to();
        $enablePrettyUrl = UsniAdaptor::app()->urlManager->enablePrettyUrl;
        if(!$enablePrettyUrl)
        {
            $queryParams    = UsniAdaptor::app()->request->getQueryParams();
            $baseUrl        = UsniAdaptor::app()->request->baseUrl . '/index.php?r=' . urlencode($queryParams['r']) . '&id=';
        }
        else
        {
            $parts      = explode('?', $url);
            $baseUrl    = $parts[0] . '?id=';
        }
        $script     = "$('#browsemodels').on('change', function(){
                        var value   = $(this).val();
                        if(value != '')
                        {
                            var url     = '{$baseUrl}' + $(this).val();
                            window.location.href = url;
                        }
                       })";
        $this->getView()->registerJs($script);
    }
}
