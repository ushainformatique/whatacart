<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\widgets;

use usni\library\widgets\Thumbnail;
use products\models\ProductDownload;
use usni\library\utils\FileUtil;
use usni\library\utils\FileUploadUtil;
use usni\library\utils\Html;
use usni\UsniAdaptor;
use usni\fontawesome\FA;
/**
 * FileDownload renders the download for the file.
 *
 * @package products\widgets
 */
class FileDownload extends \yii\bootstrap\Widget
{
    /**
     * @var ProductDownload 
     */
    public $model;
    
    /**
     * @var string 
     */
    public $attribute;
    
    /**
     * @var boolean show delete link 
     */
    public $showDeleteLink = true;
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->model->isNewRecord === false && $this->model->{$this->attribute} != null)
        {
            $deleteLink = null;
            $extension  = FileUtil::getExtension($this->model->{$this->attribute});
            $fileType   = FileUploadUtil::getFileTypeByExtension($extension);
            if($fileType == 'image')
            {
                return Thumbnail::widget(['model' => $this->model, 
                                          'attribute' => 'file',
                                          'deleteUrl' => UsniAdaptor::createUrl('catalog/products/download/delete-image'),
                                          'showDeleteLink' => $this->showDeleteLink]);
            }
            $file       = $this->model->{$this->attribute};
            if($this->showDeleteLink)
            {
                $icon       = FA::icon('trash');
                $title      = UsniAdaptor::t('application', 'Delete');
                $deleteLink = Html::a($icon, '#', ['class' => 'delete-file', 'title' => $title]);
                $this->registerDeleteFileScript();
            }
            return Html::tag('div', $file . $deleteLink, ['class' => 'downloadfile']);
        }
        return null;
    }
    
    /**
     * Delete file script
     */
    public function registerDeleteFileScript()
    {
        $id             = $this->model['id'];
        $deleteUrl      = UsniAdaptor::createUrl('catalog/products/download/delete-file');
        $script         = "$('.delete-file').click(function(){
                                                    $.ajax({
                                                            'type':'GET',
                                                            'url':'{$deleteUrl}' + '?id=' + '{$id}',
                                                            'success':function(data)
                                                                      {
                                                                          $('.downloadfile').load(location.href + ' .downloadfile');
}
                                                          });
                                                 });";
        $this->getView()->registerJs($script);
    }
}
