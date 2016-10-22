<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views\front;

use usni\library\components\UiListView;
use products\models\ProductReview;
use common\modules\catalog\components\ListViewWidget;
use frontend\utils\FrontUtil;
use usni\UsniAdaptor;
use products\models\ProductReviewTranslated;
use usni\library\dataproviders\ArrayRecordDataProvider;
use customer\models\Customer;
use usni\library\modules\users\models\Person;
use products\models\Product;
use common\utils\ApplicationUtil;
/**
 * ReviewListView class file
 *
 * @package products\views\front
 */
class ReviewListView extends UiListView
{
    /**
     * Product whose ratings would be reviewed.
     * @var int 
     */
    public $productId;
    
    /**
     * @inheritdoc
     */
    protected function getItemView()
    {
        $theme = FrontUtil::getThemeName();
        return '@themes/' . $theme . '/views/products/_reviewlistitem';
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveDataProviderQuery()
    {
        $language       = UsniAdaptor::app()->languageManager->getDisplayLanguage();
        $prTable        = ProductReview::tableName();
        $prtTable       = ProductReviewTranslated::tableName();
        $custTable      = Customer::tableName();
        $personTable    = Person::tableName();
        $productTable   = Product::tableName();
        $query          = new \yii\db\Query();
        $query->select('pr.*, prt.review, pe.profile_image, pro.created_by as productowner')
              ->from("$prTable pr")
              ->innerJoin("$prtTable prt", 'pr.id = prt.owner_id')
              ->innerJoin("$productTable pro", 'pr.product_id = pro.id')
              ->leftJoin("$custTable cu", 'pr.created_by=cu.id')
              ->leftJoin("$personTable pe", 'cu.person_id = pe.id')
              ->where('pr.product_id = :pid AND pr.status = :status AND pr.product_id = pro.id AND pr.id = prt.owner_id 
                        AND prt.language = :lan',
                     [':pid' => $this->productId, ':status' => ProductReview::STATUS_APPROVED, ':lan' => $language])
              ->orderBy('pr.created_datetime DESC');
        return $query;
    }
    
    /**
     * @inheritdoc
     */
    public function getDataProviderClassName()
    {
        return ArrayRecordDataProvider::className();
    }
    
    /**
     * @inheritdoc
     */
    public function getPagination($metadata)
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected function shouldRenderTitle()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected function getListViewId()
    {
        return 'review-listview';
    }
    
    /**
     * @inheritdoc
     */
    protected function getListViewWidgetPath()
    {
        return ListViewWidget::className();
    }
    
    /**
     * @inheritdoc
     */
    protected function getLayout()
    {
        return "{caption}\n<div class='panel panel-content'>{items}\n{pager}</div>";
    }
    
    /**
     * @inheritdoc
     */
    protected function getEmptyText()
    {
        return "<p>" . UsniAdaptor::t('products', 'There are no reviews for the product') . "</p>";
    }
    
    /**
     * @inheritdoc
     */
    protected function getItemOptions()
    {
        return ['tag' => false];
    }
    
    /**
     * @inheritdoc
     */
    protected function getViewParams()
    {
        return ['customerId' => ApplicationUtil::getCustomerId()];
    }
}
