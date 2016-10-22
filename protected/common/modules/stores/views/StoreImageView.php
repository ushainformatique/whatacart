<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\views;

use usni\library\views\UiDetailView;
use common\modules\catalog\utils\FileUploadUtil;
/**
 * StoreImageView class file.
 * @package common\modules\stores\views
 */
class StoreImageView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                    [
                        'attribute' => 'store_logo', 
                        'value'     => FileUploadUtil::getThumbnailImage($this->model, 'store_logo'),
                        'format'    => 'raw'
                    ],
                    [
                        'attribute' => 'icon', 
                        'value'     => FileUploadUtil::getThumbnailImage($this->model, 'icon'),
                        'format'    => 'raw'
                    ],
                    'category_image_width',
                    'category_image_height',
                    'product_list_image_width',
                    'product_list_image_height',
                    'related_product_image_width',
                    'related_product_image_height',
                    'compare_image_width',
                    'compare_image_height',
                    'wishlist_image_width',
                    'wishlist_image_height',
                    'cart_image_width',
                    'cart_image_height',
                    'store_image_width',
                    'store_image_height'
               ];
    }

    /**
     * @inheritdoc
     */
    protected function shouldRenderTitle()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected static function shouldRenderCreatedAttributes()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected static function shouldRenderModifiedAttributes()
    {
        return false;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderDetailModelBrowseView()
    {
        return null;
    }
}
?>