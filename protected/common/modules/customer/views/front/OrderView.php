<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use common\modules\order\models\Order;
use usni\UsniAdaptor;
use usni\library\utils\PermissionUtil;
/**
 * OrderView class file.
 *
 * @package customer\views\front;
 */
class OrderView extends AccountPageView
{
    /**
     * Order model
     * @var Order 
     */
    public $order;
    
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        if($this->order == null)
        {
            return "<p>" . UsniAdaptor::t('order', 'There is no such order existing in the system') . "</p>";
        }
        $viewHelper         = UsniAdaptor::app()->getModule('order')->viewHelper;
        $view               = $viewHelper->getInstance('orderDetailView', ['model' => $this->order]);
        return $view->render();
    }
}
?>