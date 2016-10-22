<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\views;

use common\modules\shipping\components\ShippingActionColumn;
/**
 * ShippingGridView class file.
 * 
 * @package common\modules\shipping\views
 */
class ShippingGridView extends \common\modules\extension\views\ExtensionGridView
{
    /**
     * @inheritdoc
     */
    protected function getCategoryColumn()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveActionColumn()
    {
        return [
            'class'       => ShippingActionColumn::className(),
            'template'    => '{settings} {changestatus} {delete}'
        ];  
    }
}
?>