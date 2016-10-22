<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views;

use usni\library\utils\ButtonsUtil;
use usni\library\components\UiHtml;
use usni\library\utils\DAOUtil;
use products\models\Product;
use usni\UsniAdaptor;
use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use common\modules\order\views\OrderCartItemsView;
use products\utils\ProductUtil;
use common\modules\order\utils\OrderUtil;
use usni\library\utils\FlashUtil;
/**
 * OrderProductEditView class file.
 *
 * @package common\modules\order\views
 */
class OrderProductEditView extends UiBootstrapEditView
{
    /**
     * Order associated
     * @var Order 
     */
    public $order;
    
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        if($this->order->id == null)
        {
            $previousUrl = UsniAdaptor::createUrl('order/default/create');
        }
        else
        {
            $previousUrl = UsniAdaptor::createUrl('order/default/update', ['id' => $this->order->id]);
        }
        $cartView   = new OrderCartItemsView();
        $cartContent = $cartView->render();  
        $options    = UiHtml::tag('div', '', ['id' => 'order-product-options']);
        $elements = [
                        $cartContent,
                        'product_id'    => UiHtml::getFormSelectFieldOptions(DAOUtil::getDropdownDataBasedOnModel(Product::className()), 
                                            [], ['prompt' => UiHtml::getDefaultPrompt()]),
                        'quantity'      => ['type' => 'text'],
                        $options,
                    ];
        $metadata = [
                        'elements'  => $elements,
                        'buttons'   => [
                                            'addproduct'=> ButtonsUtil::getLinkElementData(UsniAdaptor::t('products', 'Add Product'), '#'),
                                            'continue'  => ButtonsUtil::getSubmitButton(UsniAdaptor::t('application', 'Continue'), 'product-continue'),
                                            'previous'  => array(
                                                                    'type'  => 'link',
                                                                    'label' => UsniAdaptor::t('order', 'Previous'),
                                                                    'url'   => $previousUrl
                                                                ) 
                                       ]
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function buttonOptions()
    {
        return [
            'addproduct' => array('class' => 'btn btn-info')
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        return ['quantity' => ['inputOptions' => ['value' => 1]]];
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('order', 'View Cart');
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        parent::registerScripts();
        $script             = OrderUtil::renderOptionFieldsScript();
        $this->getView()->registerJs($script);
        //Add Product to cart
        $addScript          = OrderUtil::addOrderProductScript();
        $this->getView()->registerJs($addScript);
        $this->getView()->registerJs(ProductUtil::renderOptionErrorsScript());
        $this->getView()->registerJs(OrderUtil::registerRemoveFromCartScript());
    }
    
    /**
     * @inheritdoc
     */
    protected function renderFlashMessages()
    {
        return FlashUtil::render(['outOfStockCheckoutNowAllowed', 'needMinProducts'], ['alert alert-danger', 'alert alert-danger']);
    }
}