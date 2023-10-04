<?php
 /**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;

use usni\UsniAdaptor;
use yii\helpers\Json;
/**
 * BulkScriptUtil class file. 
 * 
 * @package usni\library\utils
 */
class BulkScriptUtil
{
    /**
     * Register bulkDelete script.
     *
     * @param string  $url        Url to send ajax response.
     * @param integer $id         GridView id.
     */
    public static function registerBulkDeleteScript($url, $gridViewId, $view, $pjaxId)
    {
        $confirmation   = "if(!confirm(".  Json::encode(UsniAdaptor::t('application', 'Are you sure you want to perform bulk delete?')).")) return false;";
        $scriptBody     = self::renderScriptBody($url, $gridViewId, $confirmation, $pjaxId);
        $view->registerJs("$('body').on('click', '.multiple-delete',
                                    {$scriptBody});");
    }

    /**
     * Register bulk approve script.
     *
     * @param string  $url Url to send ajax response.
     * @param integer $id  GridView id.
     */
    public static function registerBulkApproveScript($url, $gridViewId, $btnClass, $view, $pjaxId)
    {
        $scriptBody = self::renderScriptBody($url, $gridViewId, $confirmation = '', $pjaxId);
        $view->registerJs("$('body').on('click', '.bulk-{$btnClass}', {$scriptBody});");
    }

    /**
     * Register bulk unapprove script.
     *
     * @param string  $url Url to send ajax response.
     * @param integer $id  GridView id.
     */
    public static function registerBulkUnApproveScript($url, $gridViewId, $btnClass, $view, $pjaxId)
    {
       $scriptBody = self::renderScriptBody($url, $gridViewId, $confirmation = '', $pjaxId);
       $view->registerJs("$('body').on('click', '.bulk-{$btnClass}', {$scriptBody});");
    }

    /**
     * Renders bulk script body
     * @param string $url.
     * @param string $gridViewId.
     * @param string $confirmation.
     * @return string
     */
    protected static function renderScriptBody($url, $gridViewId, $confirmation = '', $sourceId)
    {
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
     * @param string $route
     * @param string $formId
     * @param string $gridViewId
     * @param string $pjaxId
     */
    public function registerBulkEditScript($route, $formId, $gridViewId, $pjaxId)
    {
        $url        = UsniAdaptor::createUrl($route);
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
                        return false;
                    }
                    var paramStr    = '&selectedIds=' + idList;
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
}
