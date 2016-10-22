<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\views;

use usni\library\views\UiDetailView;
use usni\library\utils\AdminUtil;
use taxes\utils\TaxUtil;
use customer\utils\CustomerUtil;
use common\modules\localization\modules\orderstatus\utils\OrderStatusUtil;
/**
 * StoreSettingsView class file.
 * 
 * @package common\modules\stores\views
 */
class StoreSettingsView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                    'catalog_items_per_page',
                    'list_description_limit',
                    ['attribute' => 'display_price_with_tax', 'value' => AdminUtil::getYesNoOptionDisplayText($this->model['display_price_with_tax'])],
                    ['attribute' => 'tax_calculation_based_on', 'value' => TaxUtil::getBasedOnDisplayValue($this->model['tax_calculation_based_on'])],
                    ['attribute' => 'customer_online', 'value' => AdminUtil::getYesNoOptionDisplayText($this->model['customer_online'])],
                    ['attribute' => 'default_customer_group', 'value' => CustomerUtil::getCustomerGroupById($this->model['default_customer_group'])],
                    'customer_prefix',
                    'order_prefix',
                    ['attribute' => 'guest_checkout', 'value' => AdminUtil::getYesNoOptionDisplayText($this->model['guest_checkout'])],
                    ['attribute' => 'order_status', 'value' => OrderStatusUtil::getLabel($this->model['order_status'])],
                    ['attribute' => 'display_stock', 'value' => AdminUtil::getYesNoOptionDisplayText($this->model['display_stock'])],
                    ['attribute' => 'show_out_of_stock_warning', 'value' => AdminUtil::getYesNoOptionDisplayText($this->model['show_out_of_stock_warning'])],
                    ['attribute' => 'allow_out_of_stock_checkout', 'value' => AdminUtil::getYesNoOptionDisplayText($this->model['allow_out_of_stock_checkout'])],
                    ['attribute' => 'allow_reviews', 'value' => AdminUtil::getYesNoOptionDisplayText($this->model['allow_reviews'])],
                    ['attribute' => 'allow_guest_reviews', 'value' => AdminUtil::getYesNoOptionDisplayText($this->model['allow_guest_reviews'])],
                    ['attribute' => 'allow_wishlist', 'value' => AdminUtil::getYesNoOptionDisplayText($this->model['allow_wishlist'])],
                    ['attribute' => 'allow_compare_products', 'value' => AdminUtil::getYesNoOptionDisplayText($this->model['allow_compare_products'])],
                    ['attribute' => 'display_dimensions', 'value' => AdminUtil::getYesNoOptionDisplayText($this->model['display_dimensions'])],
                    ['attribute' => 'display_weight', 'value' => AdminUtil::getYesNoOptionDisplayText($this->model['display_weight'])]
               ];
    }

    /**
     * @inheritdoc
     */
    protected function shouldRenderTitle()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected static function shouldRenderCreatedAttributes()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected static function shouldRenderModifiedAttributes()
    {
        return false;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderDetailModelBrowseView()
    {
        return null;
    }
}
?>