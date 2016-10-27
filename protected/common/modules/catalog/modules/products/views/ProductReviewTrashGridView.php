<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use products\components\ReviewStatusDataColumn;
use products\utils\ProductUtil;
use products\components\ProductReviewActionColumn;
use usni\UsniAdaptor;
use usni\library\utils\DAOUtil;
use products\models\Product;
use Yii;
use products\models\ProductReview;
use usni\library\modules\auth\managers\AuthManager;
use yii\data\ActiveDataProvider;
use usni\library\extensions\bootstrap\widgets\UiGridViewActionToolBar;
use products\components\ProductReviewTrashGridViewActionButtonGroup;
/**
 * ProductReview trash Grid View.
 * 
 * @package products\views
 */
class ProductReviewTrashGridView extends ProductReviewGridView
{
    /**
     * @inheritdoc
     */
    public function __construct($config)
    {
        Yii::configure($this, $config);
        $this->pjaxContainerId = strtolower(UsniAdaptor::getObjectClassName($this->model)) . 'gridview-pjax';
    }
    
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
                           'template'   => '{deletetrash}'
                    ]
            ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getDataProvider()
    {
        $query      = ProductReview::find()->where('status = :status', [':status' => ProductReview::STATUS_DELETED]);
        return new ActiveDataProvider(['query' => $query]);
    }
    
    /**
     * @inheritdoc
     */
    public static function getGridViewActionToolBarClassName()
    {
        return UiGridViewActionToolBar::className();
    }
    
    /**
     * @inheritdoc
     */
    protected static function getActionToolbarOptions()
    {
        $toolbarOptions = parent::getActionToolbarOptions();
        $toolbarOptions['showBulkEdit'] = false;
        $toolbarOptions['gridViewActionButtonGroup'] = ProductReviewTrashGridViewActionButtonGroup::className();
        return $toolbarOptions;
    }
}