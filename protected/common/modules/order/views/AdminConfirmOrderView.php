<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views;

use usni\UsniAdaptor;
use usni\library\components\UiActiveForm;
use usni\library\utils\ButtonsUtil;
use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\components\UiHtml;
use usni\library\utils\DAOUtil;
use common\modules\localization\modules\orderstatus\models\OrderStatus;
use cart\views\AdminConfirmCartSubView;
/**
 * AdminConfirmOrderView class file.
 * @package common\modules\order\views
 */
class AdminConfirmOrderView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = array(
                    'content'   => array('type' => UiActiveForm::INPUT_RAW, 'value' => $this->getCartContent()),
                    'status'    => UiHtml::getFormSelectFieldOptions(DAOUtil::getDropdownDataBasedOnModel(OrderStatus::className()), [], ['placeholder' => UiHtml::getDefaultPrompt()]),
                    'comments'  => ['type' => 'textarea'],
        );
        $metadata = array(
            'elements'    => $elements,
            'buttons'     => ['confirm'   => ButtonsUtil::getSubmitButton(UsniAdaptor::t('application', 'Submit'), 'confirm-order-btn'),
                              'previous'  => array(
                                                        'type'  => 'link',
                                                        'label' => UsniAdaptor::t('order', 'Previous'),
                                                        'url'   => UsniAdaptor::createUrl('order/default/checkout')
                                                  )
                             ]
        );
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function getCartContent()
    {
        $cartSubView    = new AdminConfirmCartSubView();
        return UiHtml::tag('div', $cartSubView->render(), ['id' => 'shopping-cart-container']);
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('cart', 'Confirm Order');
    }
}