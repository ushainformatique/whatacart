<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\models;

use usni\UsniAdaptor;
/**
 * StoreSettings active record.
 *
 * @package common\modules\stores\models
 */
class StoreSettings extends \yii\base\Model
{   
    public $invoice_prefix;
    public $catalog_items_per_page;
    public $list_description_limit;
    public $display_price_with_tax;
    public $tax_calculation_based_on;
    public $guest_checkout; 
    public $order_status;
    public $display_stock;
    public $customer_online;
    public $default_customer_group;
    public $allow_reviews;
    public $allow_guest_reviews;
    public $show_out_of_stock_warning;
    public $allow_out_of_stock_checkout;
    public $allow_wishlist;
    public $allow_compare_products; 
    public $customer_prefix;
    public $order_prefix;
    public $display_weight;
    public $display_dimensions;


    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['invoice_prefix', 'catalog_items_per_page', 'list_description_limit', 'customer_prefix', 'order_prefix'],     'required'],
                    [['catalog_items_per_page', 'list_description_limit'], 'number', 'integerOnly' => true],
                    [['invoice_prefix', 'catalog_items_per_page', 'list_description_limit', 'display_price_with_tax', 'tax_calculation_based_on', 
                      'guest_checkout', 'order_status', 'display_stock', 'customer_online', 'default_customer_group', 'allow_reviews', 
                      'allow_guest_reviews', 'show_out_of_stock_warning', 'allow_out_of_stock_checkout', 'allow_wishlist', 'allow_compare_products', 
                      'customer_prefix', 'order_prefix', 'display_weight', 'display_dimensions'],   'safe'],
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario = parent::scenarios();
        $scenario['create'] = $scenario['update'] = ['invoice_prefix', 'catalog_items_per_page', 'list_description_limit', 'display_price_with_tax', 
        'tax_calculation_based_on', 'guest_checkout', 'order_status', 'display_stock', 'customer_online', 'default_customer_group', 'allow_reviews', 
        'allow_guest_reviews', 'show_out_of_stock_warning', 'allow_out_of_stock_checkout', 'allow_wishlist', 'allow_compare_products', 
        'customer_prefix', 'order_prefix', 'display_weight', 'display_dimensions'];
        return $scenario;
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		return [
                        'id'                            => UsniAdaptor::t('application','Id'),
                        'invoice_prefix'                => UsniAdaptor::t('stores','Invoice Prefix'),
                        'catalog_items_per_page'        => UsniAdaptor::t('stores', 'Number of items per page for catalog'),
                        'list_description_limit'        => UsniAdaptor::t('stores', 'List Description  Limit'),
                        'display_price_with_tax'        => UsniAdaptor::t('stores', 'Display Price With Tax'),
                        'tax_calculation_based_on'      => UsniAdaptor::t('stores', 'Tax Calculation Based On'),
                        'guest_checkout'                => UsniAdaptor::t('stores', 'Guest Checkout'),
                        'order_status'                  => UsniAdaptor::t('orderstatus', 'Order Status'),
                        'display_stock'                 => UsniAdaptor::t('stores', 'Display Stock'),
                        'customer_online'               => UsniAdaptor::t('stores', 'Customer Online'),
                        'default_customer_group'        => UsniAdaptor::t('stores', 'Default Customer Group'),
                        'allow_reviews'                 => UsniAdaptor::t('stores', 'Allow Reviews'),
                        'allow_guest_reviews'           => UsniAdaptor::t('stores', 'Allow Guest Reviews'),
                        'show_out_of_stock_warning'     => UsniAdaptor::t('stores', 'Show out of stock warning'),
                        'allow_out_of_stock_checkout'   => UsniAdaptor::t('stores', 'Allow out of stock checkout'),
                        'allow_wishlist'                => UsniAdaptor::t('stores', 'Allow Wishlist'),
                        'allow_compare_products'        => UsniAdaptor::t('stores', 'Allow Compare Products'),
                        'customer_prefix'               => UsniAdaptor::t('stores', 'Customer Prefix'),
                        'order_prefix'                  => UsniAdaptor::t('stores', 'Order Prefix'),
                        'display_weight'                => UsniAdaptor::t('stores', 'Display Weight'),
                        'display_dimensions'            => UsniAdaptor::t('stores', 'Display Dimensions'),
                  ];
	}
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('settings', 'Settings');
    }
    
    /**
     * @inheritdoc
     */
	public function attributeHints()
	{
		$hints = [
                        'invoice_prefix'            => UsniAdaptor::t('storehint','Set the invoice prefix (e.g. USNI). Invoice IDs will start at 1 for each unique prefix.'),
                        'catalog_items_per_page'    => UsniAdaptor::t('storehint', 'Determines how many catalog items are shown per page (products, categories, etc).'),
                        'list_description_limit'    => UsniAdaptor::t('storehint', 'In the list view, short description character limit (categories, special etc).'),
                        'display_price_with_tax'    => UsniAdaptor::t('storehint', 'Display Prices With Tax'),
                        'guest_checkout'            => UsniAdaptor::t('storehint', 'Allow customers to checkout without creating an account. This will not be available when a downloadable product is in the shopping cart.'),
                        'order_status'              => UsniAdaptor::t('storehint', 'Set the default order status when an order is processed.'),
                        'display_stock'             => UsniAdaptor::t('storehint', 'Display stock quantity on the product page.'),
                        'customer_online'           => UsniAdaptor::t('storehint', 'Track customers online via the customer reports section.'),
                        'default_customer_group'    => UsniAdaptor::t('storehint', 'Default Customer Group'),
                        'allow_reviews'             => UsniAdaptor::t('storehint', 'Allow reviews on the product page'),
                        'allow_guest_reviews'       => UsniAdaptor::t('storehint', 'Allow guests to post reviews.'),
                        'show_out_of_stock_warning' => UsniAdaptor::t('storehint', 'Show out of stock warning if item is not in stock'),
                        'allow_out_of_stock_checkout' => UsniAdaptor::t('storehint', 'Allow checkout if item is not in stock'),
                        'allow_wishlist'              => UsniAdaptor::t('storehint', 'Allow store to display wishlist'),
                        'allow_compare_products'      => UsniAdaptor::t('storehint', 'Allow store to display compare products'),
                        'display_weight'              => UsniAdaptor::t('storehint', 'Display weight of product.'),
                        'display_dimensions'          => UsniAdaptor::t('storehint', 'Display dimensions of product.'),
                        'discount_amount_per_point'   => UsniAdaptor::t('storehint', 'Discount amount customer will get per point.')
                  ];
        return $hints;
	}
}