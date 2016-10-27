<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\components;

use usni\library\extensions\bootstrap\widgets\TranslatableGridViewActionButtonGroup;
use usni\UsniAdaptor;
/**
 * ProductReviewTrashGridViewActionButtonGroup class file.
 * 
 * @package products\views  
 */
class ProductReviewTrashGridViewActionButtonGroup extends TranslatableGridViewActionButtonGroup
{
    /**
     * @inheritdoc
     */
    protected function getBulkDeleteUrl()
    {
        return UsniAdaptor::createUrl('/' . $this->getModuleId() . '/' . $this->controller->id . '/trash-bulk-delete');
    }
}
