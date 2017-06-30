<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\widgets;

use usni\UsniAdaptor;
use common\utils\ApplicationUtil;
use common\web\ImageBehavior;
/**
 * ReviewListView class file
 *
 * @package products\widgets
 */
class ReviewListView extends \yii\widgets\ListView
{
    /**
     * @inheritdoc
     */
    public $itemView = '/front/_reviewlistitem';
    
    /**
     * @inheritdoc
     */
    public $layout = "<div class='panel panel-content'>{items}\n{pager}</div>";
    
    /**
     * @inheritdoc
     */
    public $itemOptions = ['tag' => false];
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->emptyText = UsniAdaptor::t('products', 'There are no reviews for the product') ;
        $this->viewParams['customerId'] = ApplicationUtil::getCustomerId();
        $this->getView()->attachBehavior('imageBehavior', ImageBehavior::className());
    }
    
    /**
     * @inheritdoc
     */
    public function getId($autoGenerate = true)
    {
        return 'review-listview';
    }
}