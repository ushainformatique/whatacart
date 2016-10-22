<?php
namespace cart\views;

use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
/**
 * CompleteOrderView class file.
 * @package cart\views
 */
class CompleteOrderView extends \frontend\views\FrontPageView
{
    /**
     * Order associated
     * @var Order 
     */
    public $order;
    
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $file       = UsniAdaptor::getAlias('@themes/' . FrontUtil::getThemeName() . '/views/cart/_completedOrder.php');
        $content    = $this->getView()->renderPhpFile($file, ['order' => $this->order]);
        return $content;
    }
}