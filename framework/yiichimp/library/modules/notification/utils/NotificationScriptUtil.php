<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\utils;

use usni\UsniAdaptor;
/**
 * NotificationScriptUtil class file.
 * 
 * @package usni\library\modules\notification\utils
 */
class NotificationScriptUtil
{
    /**
     * Registers notification preview script.
     * @param string $url
     * @param string $editViewId
     * @see http://stackoverflow.com/questions/24398225/ckeditor-doesnt-submit-data-via-ajax-on-first-submit
     * @return void
     */
    public static function registerPreviewScript($url, $editViewId, $view)
    {
        $editViewId = strtolower($editViewId);
        $editViewId = UsniAdaptor::getObjectClassName($editViewId);
        $view->registerJs("
                            $('body').on('click', '#preview-button',
                            function()
                            {
                              var data = $('#$editViewId').serialize();
                              $.ajax({
                                 'type' : 'post',
                                 'url'  : '{$url}',
                                 'data' : data,
                                 'beforeSend' : function()
                                                {
                                                  attachButtonLoader($('#$editViewId'));
                                                },
                                 'success'    : function(data)
                                                {
                                                  $('.modal-body').html(data);
                                                  $('#previewModal').modal('show');
                                                  removeButtonLoader($('#$editViewId'));
                                                }
                              });
                              return false;
                             });
                          ", \yii\web\View::POS_END);
    }

    /**
     * Registers notification grid preview script.
     * @param string $url
     * @param string $gridViewId
     * @param \yii\web\View $view
     * @see http://stackoverflow.com/questions/24398225/ckeditor-doesnt-submit-data-via-ajax-on-first-submit
     * @return void
     */
    public static function registerGridPreviewScript($url, $gridViewId, $view)
    {
        $view->registerJs("
                            $('body').on('click', '.grid-preview-link',
                            function()
                            {
                              var id = $(this).data('id');
                              $.ajax({
                                 'type' : 'post',
                                 'url'  : '{$url}' + '?id=' + id,
                                 'beforeSend' : function()
                                                {
                                                  attachButtonLoader($('#$gridViewId'));
                                                },
                                 'success'    : function(data)
                                                {
                                                  $('#gridPreviewModal').find('.modal-body').html(data);
                                                  $('#gridPreviewModal').modal('show');
                                                  removeButtonLoader($('#$gridViewId'));
                                                }
                              });
                              return false;
                             });
                          ", \yii\web\View::POS_END);
    }
}