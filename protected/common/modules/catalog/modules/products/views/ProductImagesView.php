<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use usni\UsniAdaptor;
/**
 * ProductImagesView class file.
 * @package products\views
 */
class ProductImagesView extends ProductImagesEditView
{
    /**
     * @inheritdoc
     */
    protected function getFilePath()
    {
        return UsniAdaptor::getAlias('@common/modules/catalog/modules/products/views/_productViewImageRow') . '.php';
    }
    
    /**
     * @inheritdoc
     */
    protected function getMainFilePath()
    {
        return UsniAdaptor::getAlias('@common/modules/catalog/modules/products/views/_productViewImageValues') . '.php';
    }
}
?>