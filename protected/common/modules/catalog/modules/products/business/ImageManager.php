<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\business;

use products\models\ProductImage;
use usni\UsniAdaptor;
/**
 * Implements functionality related to product image.
 *
 * @package products\business
 */
class ImageManager extends \usni\library\business\Manager
{
    /**
     * Process delete image.
     * @param integer $id
     * @return boolean
     */
    public function processDeleteImage($id)
    {
        $model          = ProductImage::findOne($id);
        $isPermissible  = UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, 'product.deleteother');
        if(!$isPermissible)
        {
            return false;
        }
        else
        {
            return $this->deleteModel($model);
        }
    }
}
