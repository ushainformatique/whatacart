<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\enhancement\views;

use common\modules\enhancement\components\EnhancementActionColumn;
/**
 * EnhancementGridView class file.
 * @package common\modules\payment\views
 */
class EnhancementGridView extends \common\modules\extension\views\ExtensionGridView
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
            'class'       => EnhancementActionColumn::className(),
            'template'    => '{settings} {changestatus}'
        ];  
    }
}
?>