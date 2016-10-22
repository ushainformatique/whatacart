<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\views;

use usni\library\utils\ButtonsUtil;
use usni\library\components\UiActiveForm;
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use common\modules\stores\utils\StoreUtil;
use usni\library\utils\FileUploadUtil;
/**
 * StoreImageEditView class file
 *
 * @package common\modules\stores\views
 */
class StoreImageEditView extends \usni\library\views\MultiModelEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $this->setDefaultValues();
        $elements = [
                        $this->renderStoreLogoThumbnail(),
                        'store_logo'                      => ['type' => UiActiveForm::INPUT_FILE, 'visible' => 'true'],
                        $this->renderIconThumbnail(),
                        'icon'                            => ['type' => UiActiveForm::INPUT_FILE, 'visible' => 'true'],
                        UiHtml::beginTag('div', ['class' => 'row']),
                        UiHtml::beginTag('div', ['class' => 'col-sm-6']),
                            'category_image_width'            => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::beginTag('div', ['class' => 'col-sm-6']),
                            'category_image_height'           => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::endTag('div'),
            
                        UiHtml::beginTag('div', ['class' => 'row']),
                        UiHtml::beginTag('div', ['class' => 'col-sm-6']),
                            'product_list_image_width'        => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::beginTag('div', ['class' => 'col-sm-6']),
                            'product_list_image_height'       => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::endTag('div'),
            
                        UiHtml::beginTag('div', ['class' => 'row']),
                        UiHtml::beginTag('div', ['class' => 'col-sm-6']),
                            'related_product_image_width'     => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::beginTag('div', ['class' => 'col-sm-6']),
                            'related_product_image_height'    => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::endTag('div'),
            
                        UiHtml::beginTag('div', ['class' => 'row']),
                        UiHtml::beginTag('div', ['class' => 'col-sm-6']),
                            'compare_image_width'             => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::beginTag('div', ['class' => 'col-sm-6']),
                            'compare_image_height'            => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::endTag('div'),
            
                        UiHtml::beginTag('div', ['class' => 'row']),
                        UiHtml::beginTag('div', ['class' => 'col-sm-6']),
                            'wishlist_image_width'            => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::beginTag('div', ['class' => 'col-sm-6']),
                            'wishlist_image_height'           => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::endTag('div'),
            
                        UiHtml::beginTag('div', ['class' => 'row']),
                        UiHtml::beginTag('div', ['class' => 'col-sm-6']),
                            'cart_image_width'                => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::beginTag('div', ['class' => 'col-sm-6']),
                            'cart_image_height'               => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::endTag('div'),
                        
                        UiHtml::beginTag('div', ['class' => 'row']),
                        UiHtml::beginTag('div', ['class' => 'col-sm-6']),
                            'store_image_width'               => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::beginTag('div', ['class' => 'col-sm-6']),
                            'store_image_height'              => ['type' => 'text'],
                        UiHtml::endTag('div'),
                        UiHtml::endTag('div'),
                    ];
        $metadata = [
                        'elements'          => $elements,
                        'buttons'           => ButtonsUtil::getDefaultButtonsMetadata("stores/default/manage")
                    ];
        return $metadata;
    }
    
    /**
     * Renders store logo thumbnail.
     * @return string or null
     */
    protected function renderStoreLogoThumbnail()
    {
        if (UsniAdaptor::app()->controller->action->id == 'update')
        {
            if ($this->model->store_logo != null)
            {
                return FileUploadUtil::getThumbnailImage($this->model, 'store_logo');
            }
        }
        return null;
    }
    
    /**
     * Renders icon thumbnail.
     * @return string or null
     */
    protected function renderIconThumbnail()
    {
        if (UsniAdaptor::app()->controller->action->id == 'update')
        {
            if ($this->model->icon != null)
            {
                return UiHtml::img(UsniAdaptor::app()->getAssetManager()->getImageUploadUrl() . DS . $this->model->icon);
            }
        }
        return null;
    }
    
    /**
     * Set default values
     * @return void
     */
    protected function setDefaultValues()
    {
        $defaultImageDataSet = StoreUtil::getDefaultImageDataSet();
        foreach($defaultImageDataSet as $key => $value)
        {
            $this->model->$key = $value;
        }
    }
}