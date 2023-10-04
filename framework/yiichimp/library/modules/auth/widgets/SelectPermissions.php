<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\widgets;

use usni\library\utils\Html;
use usni\UsniAdaptor;
use yii\helpers\Inflector;
/**
 * SelectPermissions renders the permissions for the applications to assign to the
 * selected identity [IAuthIdentity]
 *
 * @package usni\library\modules\auth\widgets
 */
class SelectPermissions extends \yii\bootstrap\Widget
{
    public $model;
    
    public $attribute;
    
    public $modulesPermissionCountMap;
    
    public $identityModuleAssignmentMap;
    
    public $layout = "<hr/><div id='permissionsSelect' class='permissionsContainer'><div class='panel panel-body'>{content}</div></div>";
    
    public $modulePermissionsLayout = "<div class='modulePermissionsContainer'>{moduleContent}</div>";
    
    /**
     * inheritdoc
     */
    public function run()
    {
        $selectAllLabel     = UsniAdaptor::t('application', 'Select All');
        $modulePermissions  = $this->model->permissions;
        $list               = null;
        $checked            = $this->checkIfAllPermissionsSelected();
        $content            = Html::checkbox('selectAll',
                                                  $checked,
                                                  array('label' => '<span class="selectLabel">' . $selectAllLabel . '</span>',
                                                        'labelOptions' => array('class' => 'checkbox-inline selectAllCheckBoxLabel'),
                                                        'id' => 'selectAllChk'));
        foreach($modulePermissions as $moduleId => $permissionSet)
        {
            $moduleString       = Inflector::camel2words(ucfirst($moduleId));
            $permissionContent  = Html::tag('legend', $moduleString);
            ksort($permissionSet);
            foreach($permissionSet as $resource => $permissions)
            {
                if(strpos($resource, 'Module') === false)
                {
                    $resourceString = Inflector::camel2words($resource);
                    $permissionContent .= Html::tag('h4', $resourceString);
                }
                $permissionContent .= Html::activeCheckBoxList($this->model,
                                                               $this->attribute,
                                                               $permissions,
                                                               array('item' => [$this, 'getPermissionCheckBoxItem'],
                                                                  'unselect' => null,
                                                                  'id' => strtolower($resource)));
                $permissionContent .= '<br/>';
            }
            $list .= str_replace('{moduleContent}', $permissionContent, $this->modulePermissionsLayout);
        }
        $content .= str_replace('{content}', $list, $this->layout);
        $this->registerSelectUnselectAllScriptForCheckBox('selectAllCheckBoxLabel',
                                                        'selectAllChk',
                                                        'authitem');
        return $content;
    }
    
    /**
     * Check if all permissions selected
     * @return boolean
     */
    public function checkIfAllPermissionsSelected()
    {
        $modulePermissions  = $this->model->permissions;
        $isAllPermissionsSelected = true;
        $moduleIds          = array_keys($modulePermissions);
        foreach($moduleIds as $moduleId)
        {
            $count = $this->identityModuleAssignmentMap[$moduleId];
            
            $permissionCount = $this->modulesPermissionCountMap[$moduleId];
            if($count == 0 || $count != $permissionCount)
            {
                $isAllPermissionsSelected = false;
                break;
            }
        }
        if($isAllPermissionsSelected)
        {
            return true;
        }
        return false;
    }
    
    /**
     * Register select all and unselect all script
     * @param string $checkBoxSelectorSelectClass
     * @param string $checkBoxSelectorSelectId
     * @param string $itemSelector
     */
    public function registerSelectUnselectAllScriptForCheckBox($checkBoxSelectorSelectClass,
                                                               $checkBoxSelectorSelectId,
                                                               $itemSelector)
    {
        $script = "$('body').on('click', '.{$checkBoxSelectorSelectClass}',
                     function(){
                                    var isChecked = $('#{$checkBoxSelectorSelectId}').is(':checked');
                                    if(isChecked)
                                    {
                                        $('.{$itemSelector}').prop('checked', true);
                                    }
                                    else
                                    {
                                        $('.{$itemSelector}').prop('checked', false);
                                    }
                                    
                                })";
        $this->getView()->registerJs($script);
    }
    
    /**
     * Get the permission checkbox html.
     * 
     * The data would be as
     * [permissions] => Array
        (
            [auth] => Array
                (
                    [access.auth] => Access Tab
                    [auth.managepermissions] => Manage Permissions
                )
     * )
     * @see BaseHtml::checkboxList for params description
     */
    public function getPermissionCheckBoxItem($index, $label, $name, $checked, $value)
    {
        $baseId     = Html::getInputId($this->model, $this->attribute);
        $inputId    = $baseId . '-' . $value;
        $checkbox   = Html::checkbox($name, $checked, ['class' => 'authitem', 'value' => $value, 'id' => $inputId]);
        $output     = Html::label($checkbox . $label, $inputId, ['class' => 'checkbox-inline authpermissioncheckbox']);
        return $output;
    }
}
