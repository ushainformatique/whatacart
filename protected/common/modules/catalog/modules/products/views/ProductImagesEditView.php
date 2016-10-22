<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use usni\UsniAdaptor;
use usni\library\views\UiView;
use products\utils\ProductUtil;
/**
 * ProductImagesEditView class file.
 *
 * @package products\views
 */
class ProductImagesEditView extends UiView
{
    /**
     * Product for which images has to be added.
     * @var Addon
     */
    public $product;
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $productImages   = $this->product->images;
        if(empty($productImages))
        {
            $productImages   = ProductUtil::getProductImages($this->product->id);
        }
        $filePath           = $this->getFilePath();
        $mainFilePath       = $this->getMainFilePath();
        $rowContent         = null;
        $deleteUrl          = UsniAdaptor::createUrl('catalog/products/product-image/delete');
        foreach($productImages as $index => $productImage)
        {
            $rowContent .= $this->getView()->renderPhpFile($filePath, ['image'       => $productImage['image'],
                                                                       'caption'     => $productImage['caption'],
                                                                       'index'       => $index,
                                                                       'productImageId' => $productImage['id'],
                                                                       'deleteUrl'   => $deleteUrl]);
        }
        $content  = $this->getView()->renderPhpFile($mainFilePath, ['rows' => $rowContent]);
        return $content;
    }
    
    /**
     * Override to register form submit script
     */
    protected function registerScripts()
    {
        $script     = " $('body').on('click', '#add-productimage-value-row',
                                    function(event, jqXHR, settings)
                                    {
                                        var rowCount         = $('#productimage-value-table > tbody tr').length;
                                        if(rowCount <= 4)
                                        {
                                            var newTr            = $('.productimage-value-row-dummy').clone();
                                            $(newTr).removeClass('productimage-value-row-dummy').addClass('productimage-value-row');
                                            var newId            = 'productimage-value-row-' + (rowCount);
                                            $(newTr).attr('id', newId);
                                            var htmlContent = $(newTr).html();
                                            var content = htmlContent.replace(/##dummyindex##/g, rowCount);
                                            $(newTr).html(content);
                                            $(newTr).appendTo('#productimage-value-table tbody');
                                            $(newTr).show();
                                        }
                                    }
                                );
                                ";
        $this->getView()->registerJs($script);
        
        $script = "$.fn.extend({
                    removeProductImage:function(url, productImageId)
                    {
                        $.ajax({
                                url: url,
                                type: 'get',
                                data: 'id=' + productImageId,
                                dataType: 'json',
                                success: function(json) {	
                                }
                            });
                    }
                    })";
        $this->getView()->registerJs($script);
    }
    
    /**
     * Get file path.
     * @return string
     */
    protected function getFilePath()
    {
        return UsniAdaptor::getAlias('@common/modules/catalog/modules/products/views/_productImageRow') . '.php';
    }
    
    /**
     * Get main file path.
     * @return string
     */
    protected function getMainFilePath()
    {
        return UsniAdaptor::getAlias('@common/modules/catalog/modules/products/views/_productImageValues') . '.php';
    }
}
?>