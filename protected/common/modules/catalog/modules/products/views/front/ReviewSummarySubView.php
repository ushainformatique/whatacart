<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views\front;

use frontend\utils\FrontUtil;
use products\models\ProductReview;
use products\models\Product;
use usni\UsniAdaptor;
/**
 * ReviewSummarySubView class file
 *
 * @package products\views\front
 */
class ReviewSummarySubView extends \usni\library\views\UiView
{
    /**
     * Product id
     * @var Product 
     */
    public $productId;
    
    /**
     * Review count
     * @var int 
     */
    public $reviewCount;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->reviewCount == null)
        {
            $this->reviewCount = ProductReview::find()->where('product_id = :pId and status = :status', 
                                                                [':pId' => $this->productId, ':status' => ProductReview::STATUS_APPROVED])->count();
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $filePath       = $this->getSummaryFile();
        return $this->getView()->renderPhpFile($filePath, ['productId' => $this->productId, 'reviewCount' => $this->reviewCount]);
    }
    
    /**
     * Get summary file
     * @return string
     */
    protected function getSummaryFile()
    {
        $theme          = FrontUtil::getThemeName();
        return UsniAdaptor::getAlias('@themes/' . $theme . '/views/products/_reviewsummary.php');
    }
}
