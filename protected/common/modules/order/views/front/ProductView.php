<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views\front;

use common\modules\order\views\ProductView as BaseProductView;
use common\modules\order\views\front\OrderProductSubView;
/**
 * ProductView class.
 * @package common\modules\order\views\front
 */
class ProductView extends BaseProductView
{
    /**
     * @inheritdoc
     */
    protected function getContent()
    {
        $subView    = new OrderProductSubView(['order' => $this->model]);
        return $subView->render();
    }
}
