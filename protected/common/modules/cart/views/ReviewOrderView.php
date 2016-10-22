<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use common\utils\ApplicationUtil;
/**
 * ReviewOrderView class file.
 *
 * @package cart\views
 */
class ReviewOrderView extends \frontend\views\FrontPageView
{
    /**
     * Contain ConfirmOrderForm model.
     * @var Model
     */
    public $model;
    
    /**
     * @inheritdoc
     */
    protected function renderInnerContent()
    {
        $paymentMethodEditForm  = ApplicationUtil::getCheckoutFormModel('paymentMethodEditForm');
        $paymentMethod          = $paymentMethodEditForm->payment_method;
        $viewClass              = '\common\modules\payment\views\\' . $paymentMethod . '\ConfirmOrderView';
        $view                   = new $viewClass($this->model);
        return $view->render();
    }
}