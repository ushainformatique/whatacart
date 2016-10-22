<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\views;

use usni\library\utils\ButtonsUtil;
use usni\library\components\UiHtml;
use usni\library\utils\AdminUtil;
use usni\library\utils\DAOUtil;
use common\modules\localization\modules\orderstatus\models\OrderStatus;
use usni\UsniAdaptor;
use customer\utils\CustomerUtil;
use taxes\utils\TaxUtil;
use usni\library\modules\users\models\Address;
use common\modules\localization\modules\orderstatus\utils\OrderStatusUtil;
use common\modules\order\models\Order;
/**
 * StoreSettingsEditView class file
 *
 * @package common\modules\stores\views
 */
class StoreSettingsEditView extends \usni\library\views\MultiModelEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $this->setDefaultValues();
        $catalog            = UiHtml::tag('legend', UsniAdaptor::t('catalog', 'Catalog'));
        $tax                = UiHtml::tag('legend', UsniAdaptor::t('tax', 'Taxes'));
        $account            = UiHtml::tag('legend', UsniAdaptor::t('users', 'Account'));
        $checkout           = UiHtml::tag('legend', UsniAdaptor::t('cart', 'Checkout'));
        $stock              = UiHtml::tag('legend', UsniAdaptor::t('products', 'Stock'));
        $reviews            = UiHtml::tag('legend', UsniAdaptor::t('products', 'Reviews'));
        $wishlist           = UiHtml::tag('legend', UsniAdaptor::t('wishlist', 'Wishlist'));
        $compareProducts    = UiHtml::tag('legend', UsniAdaptor::t('products', 'Compare Products'));
        $local              = UiHtml::tag('legend', UsniAdaptor::t('localization', 'Local'));
        $elements = [
                        $catalog,
                        'catalog_items_per_page'        => ['type' => 'text'],
                        'list_description_limit'        => ['type' => 'text'],
                        $tax,
                        'display_price_with_tax'    => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
                        'tax_calculation_based_on'  => UiHtml::getFormSelectFieldOptions(TaxUtil::getBasedOnDropdown()),
                        $account,
                        'customer_online'           => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
                        'default_customer_group'    => UiHtml::getFormSelectFieldOptions(CustomerUtil::getCustomerGroupDropdownData()),
                        'customer_prefix'            => ['type' => 'text'],
                        $checkout,
                        'invoice_prefix'            => ['type' => 'text'],
                        'order_prefix'              => ['type' => 'text'],
                        'guest_checkout'            => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
                        'order_status'              => UiHtml::getFormSelectFieldOptions(DAOUtil::getDropdownDataBasedOnModel(OrderStatus::className())),
                        $stock,
                        'display_stock'             => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
                        'show_out_of_stock_warning' => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
                        'allow_out_of_stock_checkout' => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
                        
                        $reviews,
                        'allow_reviews'             => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
                        'allow_guest_reviews'       => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
            
                        $wishlist,
                        'allow_wishlist'            => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
            
                        $compareProducts,
                        'allow_compare_products'    => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
            
                        $local,
                        'display_dimensions'        => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
                        'display_weight'            => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
                    ];
        $metadata = [
                        'elements'          => $elements,
                        'buttons'           => ButtonsUtil::getDefaultButtonsMetadata("stores/default/manage")
                    ];
        return $metadata;
    }
    
    /**
     * Set default values
     * @return void
     */
    protected function setDefaultValues()
    {
        if($this->model->catalog_items_per_page == null)
        {
            $this->model->catalog_items_per_page = 9;
        }
        if($this->model->list_description_limit == null)
        {
            $this->model->list_description_limit = 100;
        }
        if($this->model->invoice_prefix == null)
        {
            $this->model->invoice_prefix = '#';
        }
        if($this->model->customer_prefix == null)
        {
            $this->model->customer_prefix = '#';
        }
        if($this->model->order_prefix == null)
        {
            $this->model->order_prefix = '#';
        }
        if($this->model->tax_calculation_based_on == null)
        {
            $this->model->tax_calculation_based_on = Address::TYPE_BILLING_ADDRESS;
        }
        if($this->model->order_status == null)
        {
            $this->model->order_status = OrderStatusUtil::getStatusId(Order::STATUS_PENDING);
        }
    }
}
