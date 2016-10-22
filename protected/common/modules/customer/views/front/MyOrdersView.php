<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use common\modules\order\models\MyOrderSearch;
use common\modules\order\models\Order;
use usni\UsniAdaptor;

/**
 * MyOrdersView class file.
 *
 * @package customer\views\front
 */
class MyOrdersView extends AccountPageView
{
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $filterModel        = new MyOrderSearch();
        $filterModel->load($_GET, 'MyOrderSearch');
        $viewHelper         = UsniAdaptor::app()->getModule('order')->viewHelper;
        $view               = $viewHelper->getInstance('myOrdersGridView', ['model' => new Order(), 'filterModel' => $filterModel]);
        return $view->render();
    }
}
?>