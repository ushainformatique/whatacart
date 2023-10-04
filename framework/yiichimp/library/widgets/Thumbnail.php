<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\widgets;

use usni\library\db\ActiveRecord;
use usni\library\utils\FileUploadUtil;
use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\utils\Html;
/**
 * Renders the thumbnail image with a delete link
 *
 * @package usni\library\widgets
 */
class Thumbnail extends \yii\bootstrap\Widget
{
    /**
     * @var ActiveRecord|Object 
     */
    public $model;
    
    /**
     * @var string Image attribute
     */
    public $attribute;
    
    /**
     * @var boolean show delete link 
     */
    public $showDeleteLink = true;
    
    /**
     * @var array html options related to image being rendered 
     */
    public $htmlOptions = [];
    
    /**
     * @var string Delete url 
     */
    public $deleteUrl;
    
    /**
     * inheritdoc
     */
    public function run()
    {
        $deleteLink = null;
        if(is_array($this->model))
        {
            $this->model = (object) $this->model;
        }
        if ($this->model->{$this->attribute} != null)
        {
            $ifImageExists = FileUploadUtil::checkIfFileExists(UsniAdaptor::app()->assetManager->imageUploadPath, $this->model->{$this->attribute});
            if($ifImageExists)
            {
                $thumbnail  = FileUploadUtil::getThumbnailImage($this->model, $this->attribute, $this->htmlOptions);
                $deleteLink = null;
                if($this->showDeleteLink)
                {
                    $icon       = FA::icon('trash');
                    $title      = UsniAdaptor::t('application', 'Delete Image');
                    $deleteLink = Html::a($icon, '#', ['class' => 'delete-image', 'title' => $title]);
                    $this->registerDeleteImageScript();
                }
            }
            else
            {
                $thumbnail  = FileUploadUtil::getThumbnailImage($this->model, $this->attribute, $this->htmlOptions);
            }
            return Html::tag('div', $thumbnail . $deleteLink, ['class' => 'image-thumbnail']);
        }
        return null;
    }
    
    /**
     * Delete image script
     */
    public function registerDeleteImageScript()
    {
        $id             = $this->model['id'];
        $script         = "$('.delete-image').click(function(){
                                                    $.ajax({
                                                            'type':'GET',
                                                            'url':'{$this->deleteUrl}' + '?id=' + '{$id}',
                                                            'success':function(data)
                                                                      {
                                                                          $('.image-thumbnail').load(location.href + ' .image-thumbnail');
}
                                                          });
                                                 });";
        $this->getView()->registerJs($script);
    }
}