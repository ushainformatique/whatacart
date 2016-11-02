<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\views;

use common\modules\payment\components\PaymentActionColumn;
use common\modules\payment\components\PaymentGridViewActionToolBar;
/**
 * PaymentGridView class file.
 * 
 * @package common\modules\payment\views
 */
class PaymentGridView extends \common\modules\extension\views\ExtensionGridView
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
            'class'       => PaymentActionColumn::className(),
            'template'    => '{settings} {changestatus}'
        ];  
    }
    
    /**
     * @inheritdoc
     */
    public static function getGridViewActionToolBarClassName()
    {
        return PaymentGridViewActionToolBar::className();
    }
}