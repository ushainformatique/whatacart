<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\views;

/**
 * ModificationGridView class file
 * 
 * @package common\modules\extension\views
 */
class ModificationGridView extends ExtensionGridView
{
    /**
     * @inheritdoc
     */
    protected function resolveActionColumn()
    {
        return null;  
    }
    
    /**
     * @inheritdoc
     */
    protected function getCategoryColumn()
    {
        return null;
    }
}