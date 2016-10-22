<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\views;

use usni\library\components\TranslatableGridView;
use taxes\components\ProductTaxClassActionColumn;
/**
 * ProductTaxClassGridView class file.
 *
 * @package taxes\views
 */
class ProductTaxClassGridView extends TranslatableGridView
{

    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                       'name',
                       [
                           'class'      => ProductTaxClassActionColumn::className(),
                           'template'   => '{view} {update} {delete}'
                       ]
                   ];
        return $columns;
    }
    
    /**
     * @inheritdoc
     */
    protected static function getActionToolbarOptions()
    {
        $content = parent::getActionToolbarOptions();
        $content['showBulkEdit'] = false;
        return $content;
    }
}