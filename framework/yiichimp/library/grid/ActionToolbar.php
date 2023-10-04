<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\grid;

use usni\library\utils\ArrayUtil;
use usni\UsniAdaptor;
use yii\helpers\Json;
use usni\library\utils\Html;
use usni\fontawesome\FA;
use yii\bootstrap\Dropdown;
use yii\bootstrap\Button;
use yii\helpers\Url;
/**
 * Render action toolbar on top of grid view
 *
 * @package usni\library\grid
 */
class ActionToolbar extends \yii\bootstrap\Widget
{
    /**
     * @var string
     */
    public $bulkDeleteUrl;
    
    /**
     * Id of the grid view
     * @var string 
     */
    public $gridId;
    
    /**
     * Show bulk edit button.
     * @var boolean
     */
    public $showBulkEdit = false;

    /**
     * Show bulk delete button.
     * @var boolean
     */
    public $showBulkDelete = false;

    /**
     * Show create button.
     * @var boolean
     */
    public $showCreate = true;
    
    /**
     * Pjax container id of the grid view
     * @var string 
     */
    public $pjaxId;
    
    /**
     * @var string
     */
    public $createUrl;
    
    /**
     * @var array 
     */
    public $perPageOptions = [2, 5, 10, 15, 20, 25];
    
    /**
     * Show bulk delete button.
     * @var boolean
     */
    public $showPerPageOption = true;
    
    /**
     * Layout for the action toolbar
     * @var string 
     */
    public $layout = "<div class='block'>
                        <div class='well text-center'>
                            <div class='action-toolbar btn-toolbar'>
                            {create}\n{perPage}\n{modalDetail}\n{bulkedit}\n{bulkdelete}
                            </div>
                        </div>
                        <div class='toolbar-content'>
                            {bulkeditform}
                        </div>
                      </div>";
    
    /**
     * View file for bulk edit form
     * @var string 
     */
    public $bulkEditFormView;
    
    /**
     * Title for the bulk edit form
     * @var string 
     */
    public $bulkEditFormTitle;
    
    /**
     * Action url for the bulk edit form
     * @var string 
     */
    public $bulkEditActionUrl;
    
    /**
     * Form id for the bulk edit form
     * @var string 
     */
    public $bulkEditFormId;
    
    /**
     * @var string
     */
    public $bulkEditFormLayout = '<div class="bulk-edit-form" style="display: none">{content}</div>';
    
    /**
     * Params for the bulk edit view
     * @var array 
     */
    public $bulkEditViewParams = [];
    
    /**
     * @var boolean Flag to check if permissions has to be checked or not 
     */
    public $usePermissions;
    
    /**
     * @var string permission to be checked for create
     */
    public $createPermission;
    
    /**
     * @var string permission to be checked for bulk edit
     */
    public $bulkEditPermission;
    
    /**
     * @var string permission to be checked for bulk delete
     */
    public $bulkDeletePermission;
    
    /**
     * @var string prefix for permission
     */
    public $permissionPrefix;
    
    /**
     * Show modal detail option.
     * @var boolean
     */
    public $showModalDetail = true;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        if($this->usePermissions === null)
        {
            $behaviorsData = $this->getView()->context->behaviors();
            if(array_key_exists('access', $behaviorsData))
            {
                $this->usePermissions = true;
            }
            else
            {
                $this->usePermissions = false;
            }
        }
        if($this->usePermissions)
        {
            if($this->createPermission == null)
            {
                $this->createPermission = $this->permissionPrefix . '.create';
            }
            if($this->bulkEditPermission == null)
            {
                $this->bulkEditPermission = $this->permissionPrefix . '.bulk-edit';
            }
            if($this->bulkDeletePermission == null)
            {
                $this->bulkDeletePermission = $this->permissionPrefix . '.bulk-delete';
            }
        }
    }
    
    /**
     * inheritdoc
     */
    public function run()
    {
        $content = preg_replace_callback("/{\\w+}/", function ($matches) {
                $content = $this->renderSection($matches[0]);

                return $content === false ? $matches[0] : $content;
            }, $this->layout);
        return $content;
    }
    
    /**
     * Renders a section of the specified name.
     * If the named section is not supported, false will be returned.
     * @param string $name the section name, e.g., `{create}`, `{perPage}`.
     * @return string|boolean the rendering result of the section, or false if the named section is not supported.
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{create}':
                return $this->renderCreateButton();
            case '{perPage}':
                return $this->renderPerPageOptions();
            case '{modalDetail}':
                return $this->renderModalDetailOptions();
            case '{bulkedit}':
                return $this->renderBulkEditButton();
            case '{bulkdelete}':
                return $this->renderBulkDeleteButton();
            case '{bulkeditform}':
                return $this->renderBulkEditForm();
            default:
                return false;
        }
    }
    
    /**
     * Register bulkDelete script.
     */
    public function registerBulkDeleteScript()
    {
        $confirmation   = "if(!confirm(".  Json::encode(UsniAdaptor::t('application', 'Are you sure you want to perform bulk delete?')).")) return false;";
        if(is_string($this->bulkDeleteUrl))
        {
            $url = [$this->bulkDeleteUrl];
        }
        else
        {
            $url = $this->bulkDeleteUrl;
        }
        $scriptBody     = $this->renderScriptBody(Url::to($url), $confirmation);
        $this->getView()->registerJs("$('body').on('click', '.multiple-delete',
                                    {$scriptBody});");
    }
    
    /**
     * Renders bulk script body
     * @param string $url.
     * @param string $gridViewId.
     * @param string $confirmation
     * @return string
     */
    public function renderScriptBody($url, $confirmation = '')
    {
        $gridViewId = $this->gridId;
        $sourceId   = $this->pjaxId;
        $error  = UsniAdaptor::t('application', 'Please select at least one record.');
        return "function()
                {
                    $confirmation
                    var idList = $('#{$gridViewId}').yiiGridView('getSelectedRows');
                    console.log(idList);
                    if(idList == '')
                    {
                        alert('{$error}');
                        return false;
                    }
                    $.ajax({
                            'type'     : 'GET',
                            'dataType' : 'html',
                            'url'      : '{$url}',
                            'data'     : {id:idList},
                            'beforeSend':function()
                                         {
                                            $.fn.attachLoader('#{$gridViewId}');
                                         },
                            'success'  : function(data)
                                         {
                                            $.pjax.reload({container:'#{$sourceId}', 'timeout':4000});
                                            $.fn.removeLoader('#{$gridViewId}');
                                         }
                          });
                    return false;
                }";
    }
    
    /**
     * Register bulk edit script
     */
    public function registerBulkEditScript()
    {
        $gridViewId = $this->gridId;
        $pjaxId     = $this->pjaxId;
        $formId     = $this->bulkEditFormId;
        if(is_string($this->bulkEditActionUrl))
        {
            $url = Url::to([$this->bulkEditActionUrl]);
        }
        else
        {
            $url = Url::to($this->bulkEditActionUrl);
        }
        $error      = UsniAdaptor::t('application', 'Please select at least one record.');
        $this->getView()->registerJs("
            $('.bulk-edit-btn').click(function(){
                $('.bulk-edit-form').toggle();
                return false;
            });
            $('#{$formId} .selectBulkEdit').click(function(){
                        if($(this).is(':checked'))
                        {
                            var checkedId = $(this).attr('data-id');
                            console.log(checkedId);
                            console.log($('#{$formId} #'+checkedId));
                            $('#{$formId} #'+checkedId).prop('disabled',false);
                        }
                        else
                        {
                            var checkedId = $(this).attr('data-id');
                            $('#{$formId} #'+checkedId).prop('disabled',true);
                        }
                       });
            $('body').on('click', '.grid-bulk-edit-btn', function(data){
                    var idList      = $('#{$gridViewId}').yiiGridView('getSelectedRows');
                    if(idList == '')
                    {
                        alert('{$error}');
                        return false;
                    }
                    var url         = '{$url}';
                    if(url.indexOf('?') == -1)
                    {
                        var paramStr    = '?selectedIds=' + idList;
                    }
                    else
                    {
                        var paramStr    = '&selectedIds=' + idList;
                    }
                    $.ajax({
                                'type'     : 'POST',
                                'dataType' : 'html',
                                'url'      : '{$url}'+ paramStr,
                                'data'     : $('#{$formId}').serialize(),
                                'beforeSend' : function()
                                               {
                                                    $.fn.attachLoader('#{$formId}');
                                               },
                                'success'  : function(data)
                                              {
                                                $.pjax.reload({container:'#{$pjaxId}', 'timeout':10000});
                                                $.fn.removeLoader('#{$formId}');
                                                $('.bulk-edit-form').toggle();
                                              },
                                error     : function(data)
                                            {
                                                $.fn.removeLoader('#{$formId}');
                                            }
                               });
                    return false;
                });
           ");
    }
    
    /**
     * Register per page script
     */
    public function registerPerPageScript()
    {
        list($url, $params) = $this->resolveUrlAndParams('per-page');
        $operator   = $this->resolveUrlOperator($params);
        $finalUrl   = $url . $operator . 'per-page='; 
        $this->getView()->registerJs("
            $('.per-page-item-link').click(function(){
                window.location.href = '{$finalUrl}' + $(this).data('items-per-page');
            });
            ");
    }
    
    /**
     * Set url which serves as a base to which param would be added on change
     * @param string $inputParam
     * @return void
     */
    protected function resolveUrlAndParams($inputParam)
    {
        $route          = UsniAdaptor::app()->controller->getRoute();
        $params         = UsniAdaptor::app()->request->getQueryParams();
        $itemsPerPage   = ArrayUtil::getValue($params, $inputParam);
        if($itemsPerPage != null)
        {
            unset($params[$inputParam]);
        }
        return [UsniAdaptor::createUrl($route, $params), $params];
    }
    
    /**
     * Resolve url operator
     * 
     * @param array $params
     * @return string
     */
    protected function resolveUrlOperator($params)
    {
        if(empty($params))
        {
            return '?';
        }
        return '&';
    }
    
    /**
     * Register modal detail script
     */
    public function registerModalDetailScript()
    {
        list($url, $params) = $this->resolveUrlAndParams('modal-display');
        $operator   = $this->resolveUrlOperator($params);
        $finalUrl   = $url . $operator . 'modal-display='; 
        $this->getView()->registerJs("
            $('.modal-detail-item-link').click(function(){
                window.location.href = '{$finalUrl}' + $(this).data('modal-detail-value');
            });
            ");
    }
    
    /**
     * Get per page value
     * @return int
     */
    public function getPerPageValue()
    {
        $itemsPerPage = UsniAdaptor::app()->request->getQueryParam('per-page');
        if($itemsPerPage == null)
        {
            $itemsPerPage = 10;
        }
        return $itemsPerPage;
    }
    
    /**
     * Get modal display text
     * @return string
     */
    public function getModalDisplayText()
    {
        $modalDisplayParam = UsniAdaptor::app()->request->getQueryParam('modal-display');
        if($modalDisplayParam == null)
        {
            $modalDisplayParam = 'yes';
        }
        return $modalDisplayParam == 'yes' ? UsniAdaptor::t('application', 'Yes') : UsniAdaptor::t('application', 'No');
    }
    
    /**
     * Renders create button
     * @return string
     */
    public function renderCreateButton()
    {
        $createPermission = true;
        if($this->createPermission != null)
        {
            $createPermission = UsniAdaptor::app()->user->can($this->createPermission);
        }
        if($this->showCreate && $createPermission)
        {
            $link = Html::a(FA::icon('plus') . "\n" . UsniAdaptor::t('application', 'Create'), 
                                Url::to([$this->createUrl]), 
                              ["id" => "action-toolbar-create", "class" => "btn btn-default"]
                            );
            return Html::tag('div', $link, ['class' => "btn-group"]);
        }
        return null;
    }
    
    /**
     * Renders bulk edit button
     * @return string
     */
    public function renderBulkEditButton()
    {
        $bulkEditPermission = true;
        if($this->bulkEditPermission != null)
        {
            $bulkEditPermission = UsniAdaptor::app()->user->can($this->bulkEditPermission);
        }
        if($this->showBulkEdit && $bulkEditPermission)
        {
            $button = Html::button(FA::icon('pencil') . "\n" . UsniAdaptor::t('application', 'Bulk Edit'), 
                                                                                          ["id" => "action-toolbar-bulkedit",
                                                                                          "class" => "btn btn-default bulk-edit-btn"]);
            $this->registerBulkEditScript();
            return Html::tag('div', $button, ['class' => "btn-group"]);
        }
        return null;
    }
    
    /**
     * Renders bulk delete button
     * @return string
     */
    public function renderBulkDeleteButton()
    {
        $bulkDeletePermission = true;
        if($this->bulkDeletePermission != null)
        {
            $bulkDeletePermission = UsniAdaptor::app()->user->can($this->bulkDeletePermission);
        }
        if($this->showBulkDelete && $bulkDeletePermission)
        {
            $button = Html::button(FA::icon('trash') . "\n" . UsniAdaptor::t('application', 'Bulk Delete'), 
                                                                                          ["id" => "action-toolbar-bulkdelete",
                                                                                          "class" => "btn btn-default multiple-delete"]);
            $this->registerBulkDeleteScript();
            return Html::tag('div', $button, ['class' => "btn-group"]);
        }
        return null;
    }
    
    /**
     * Render per page options
     * @return string
     */
    public function renderPerPageOptions()
    {
        if($this->showPerPageOption)
        {
            $dropdown       = $this->getPerPageDropdown();
            $itemsPerPage   = $this->getPerPageValue();
            $label          = Html::tag('span', $itemsPerPage, ['id' => "per-page-display"]) . " " 
                                . UsniAdaptor::t('application', 'per page')
                                . ' ' . Html::tag('span', null, ['class' => "caret"]);
            $button         = Button::widget(['options' => ['class' => 'btn btn-default dropdown-toggle per-page-selector',
                                                      'data-toggle' => 'dropdown',
                                                      'aria-haspopup' => 'true',
                                                      'aria-expanded' => 'false'
                                                      ],
                                        'label'   => $label,
                                        'encodeLabel' => false]);
            $this->registerPerPageScript();
            return Html::tag('div', $button . $dropdown, ['class' => "btn-group"]);
        }
        return null;
    }
    
    /**
     * Get per page dropdown
     * @return strinf
     */
    protected function getPerPageDropdown()
    {
        $perPageOptions = $this->perPageOptions;
        $perPageText    = UsniAdaptor::t('application', 'per page');
        $items          = [];
        foreach($perPageOptions as $value)
        {
            $item = [
                'label' => $value . " " . $perPageText,
                'url'   => '#',
                'linkOptions' => ['class' => 'per-page-item-link', 'data-items-per-page' => $value],
            ];
            $items[] = $item;
        }
        return Dropdown::widget(['items' => $items, 'options' => ['class' => 'dropdown-menu dropdown-menu-right']]);
    }
    
    /**
     * Render modal detail options
     * @return string
     */
    public function renderModalDetailOptions()
    {
        if($this->showModalDetail)
        {
            $modalDisplay   = $this->getModalDisplayText();
            $dropdown       = $this->getModalDisplayDropdown();
            $displayedText  = UsniAdaptor::t('application', 'Modal Detail') . "\n(<strong>" . $modalDisplay . '</strong>)';
            $label          = Html::tag('span', $displayedText, ['id' => "modal-detail-display"]) 
                                . ' ' . Html::tag('span', null, ['class' => "caret"]);
            $button         = Button::widget(['options' => ['class' => 'btn btn-default dropdown-toggle modal-detail-selector',
                                                      'data-toggle' => 'dropdown',
                                                      'aria-haspopup' => 'true',
                                                      'aria-expanded' => 'false'
                                                      ],
                                        'label'   => $label,
                                        'encodeLabel' => false]);
            return Html::tag('div', $button . $dropdown, ['class' => "btn-group"]);
        }
        return null;
    }
    
    /**
     * Get modal display dropdown
     * @return strinf
     */
    protected function getModalDisplayDropdown()
    {
        $dropdownOptions    = ['yes' => UsniAdaptor::t('application', 'Yes'),
                               'no'  => UsniAdaptor::t('application', 'No')];
        $items          = [];
        foreach($dropdownOptions as $key => $value)
        {
            $item = [
                'label' => $value,
                'url'   => '#',
                'linkOptions' => ['class' => 'modal-detail-item-link', 'data-modal-detail-value' => $key],
            ];
            $items[] = $item;
        }
        $this->registerModalDetailScript();
        return Dropdown::widget(['items' => $items, 'options' => ['class' => 'dropdown-menu dropdown-menu-right']]);
    }
    
    /**
     * Render bulk edit form
     * @return string
     */
    public function renderBulkEditForm()
    {
        $bulkEditPermission = true;
        if($this->bulkEditPermission != null)
        {
            $bulkEditPermission = UsniAdaptor::app()->user->can($this->bulkEditPermission);
        }
        if($this->showBulkEdit && $bulkEditPermission)
        {
            $formContent = $this->render($this->bulkEditFormView, $this->bulkEditViewParams);
            return str_replace('{content}', $formContent, $this->bulkEditFormLayout);
        }
        return null;
    }
}
