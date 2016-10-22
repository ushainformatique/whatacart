<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use usni\library\components\TranslatableGridView;
use products\views\ProductReviewGridViewActionToolBar;
use products\components\ReviewStatusDataColumn;
use products\utils\ProductUtil;
use products\components\ProductReviewActionColumn;
use usni\UsniAdaptor;
use usni\library\utils\DAOUtil;
use products\models\Product;
/**
 * Product Grid View.
 * @package products\views
 */
class ProductReviewGridView extends TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                    'name',
                    'review',
                    [
                           'label'      => UsniAdaptor::t('products', 'Product'),
                           'attribute'  => 'product_id',
                           'value'      => 'product.name',
                           'filter'     => DAOUtil::getDropdownDataBasedOnModel(Product::className())
                    ],
                    [
                           'attribute'  => 'status',
                           'class'      => ReviewStatusDataColumn::className(),
                           'filter'     => ProductUtil::getReviewStatusDropdown()
                    ],
                    [
                           'class'      => ProductReviewActionColumn::className(),
                           'template'   => '{approve} {spam} {delete}',
                    ]
            ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getGridViewActionToolBarClassName()
    {
        return ProductReviewGridViewActionToolBar::className();
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        $modelClass = UsniAdaptor::getObjectClassName($this->model);
        $pjaxId     = strtolower($modelClass).'gridview-pjax';
        ProductUtil::registerReviewGridStatusScript('approve', $this->getView(), $pjaxId);
        ProductUtil::registerReviewGridStatusScript('unapprove', $this->getView(), $pjaxId);
        ProductUtil::registerReviewGridStatusScript('spam', $this->getView(), $pjaxId);
        ProductUtil::registerReviewGridStatusScript('remove-spam', $this->getView(), $pjaxId);
    }
}
?>