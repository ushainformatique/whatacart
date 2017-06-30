<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\utils;

use usni\UsniAdaptor;
use products\models\Product;
use common\modules\stores\utils\StoreUtil;
use usni\library\utils\FileUploadUtil;
/**
 * ProductUtil class file
 *
 * @package products\utils
 */
class ProductUtil
{
    /**
     * Get product pption type.
     * @return Array
     */
    public static function getProductOptionType()
    {
        return [
                   'select'             => 'Select',
                   'radio'              => 'Radio',
                   'checkbox'           => 'Checkbox'
               ];
    }
    
    /**
     * Get input quantity when user clicks on add to cart.
     * @param Product $product
     * @param integer $inputQty
     * @return int
     */
    public static function getAddToCartInputQuantity($product, $inputQty)
    {
        $minQuantity    = $product->minimum_quantity;
        if($inputQty != null && $inputQty >= $minQuantity)
        {
            $quantity = $inputQty;
        }
        else
        {
            $quantity = $minQuantity;
        }
        return $quantity;
    }
    
    /**
     * Get Stock Select options.
     * @return array
     */
    public static function getOutOfStockSelectOptions()
    {
        return array(
            Product::IN_STOCK      => UsniAdaptor::t('products', 'In Stock'),
            Product::OUT_OF_STOCK  => UsniAdaptor::t('products', 'Out of Stock')
        );
    }
    
    /**
     * Get product labels
     * @return array
     */
    public static function getProductLabels()
    {
        return [
                    'name'              => UsniAdaptor::t('application', 'Name'),
                    'alias'             => UsniAdaptor::t('application', 'Alias'),
                    'model'             => UsniAdaptor::t('products', 'Model'),
                    'price'             => UsniAdaptor::t('products', 'Price'),
                    'quantity'          => UsniAdaptor::t('products', 'Quantity'),
                    'description'       => UsniAdaptor::t('application', 'Description'),
                    'status'            => UsniAdaptor::t('application', 'Status'),
                    'metakeywords'      => UsniAdaptor::t('application', 'Meta Keywords'),
                    'metadescription'   => UsniAdaptor::t('application', 'Meta Description'),
                    'tagNames'          => UsniAdaptor::t('products', 'Tags'),
                    'minimum_quantity'  => UsniAdaptor::t('products', 'Minimum Quantity'),
                    'subtract_stock'    => UsniAdaptor::t('products', 'Subtract Stock'),
                    'stock_status'      => UsniAdaptor::t('products', 'Stock Status'),
                    'requires_shipping' => UsniAdaptor::t('products', 'Requires Shipping'),
                    'manufacturer'      => UsniAdaptor::t('manufacturer', 'Manufacturer'),
                    'relatedProducts'   => UsniAdaptor::t('products', 'Related Products'),
                    'attribute'         => UsniAdaptor::t('products', 'Attribute'),
                    'language_id'       => UsniAdaptor::t('localization', 'Language'),
                    'is_featured'       => UsniAdaptor::t('products', 'Featured Product'),
                    'itemPerPage'       => UsniAdaptor::t('application', 'Items Per Page'),
                    'sort_by'           => UsniAdaptor::t('application', 'Sort By'),
                    'tax_class_id'      => UsniAdaptor::t('tax', 'Tax Class'),
                    'sku'               => UsniAdaptor::t('products', 'SKU'),
                    'categories'        => UsniAdaptor::t('productCategories', 'Categories'),
                    'location'          => UsniAdaptor::t('products', 'Location'),
                    'length'            => UsniAdaptor::t('products', 'Length'),
                    'width'             => UsniAdaptor::t('products', 'Width'),
                    'height'             => UsniAdaptor::t('products', 'Height'),
                    'date_available'    => UsniAdaptor::t('products', 'Date Available'),
                    'weight'            => UsniAdaptor::t('products', 'Weight'),
                    'length_class'      => UsniAdaptor::t('lengthclass', 'Length Class'),
                    'weight_class'      => UsniAdaptor::t('weightclass', 'Weight Class'),
                    'buy_price'         => UsniAdaptor::t('products', 'Buy Price'),
                    'initial_quantity'  => UsniAdaptor::t('products', 'Initial Stock'),
                    'hits'              => UsniAdaptor::t('products','Hits'),
                    'upc'               => UsniAdaptor::t('products','UPC'),
                    'ean'               => UsniAdaptor::t('products','EAN'),
                    'jan'               => UsniAdaptor::t('products','JAN'),
                    'isbn'              => UsniAdaptor::t('products','ISBN'),
                    'mpn'               => UsniAdaptor::t('products','MPN'),
                    'download_option'   => UsniAdaptor::t('products','Download Option')
                    
               ];
    }
    
    /**
     * Get product hints
     * @return array
     */
    public static function getProductHints()
    {
        return [
                    'name'              => UsniAdaptor::t('productshint', 'Name for Product'),
                    'alias'             => UsniAdaptor::t('productshint', 'Alias for Product'),
                    'model'             => UsniAdaptor::t('productshint', 'Model for Product'),
                    'price'             => UsniAdaptor::t('productshint', 'Price for Product'),
                    'metakeywords'      => UsniAdaptor::t('productshint', 'Meta Keywords for Product'),
                    'metadescription'   => UsniAdaptor::t('productshint', 'Meta Description for Product'),
                    'tagNames'          => UsniAdaptor::t('productshint', 'Tags associated with the product. e.g - Useful Products'),
                    'minimum_quantity'  => UsniAdaptor::t('productshint', 'Minimum Quantity required to add product to the cart.'),
                    'subtract_stock'    => UsniAdaptor::t('productshint', 'Subtract Stock by the purchase quantity for e.g. If there are 100 laptops, and 2 items are purchased, stock would be reduced to 98.'),
                    'stock_status'      => UsniAdaptor::t('productshint', 'Select "Out of Stock", "In Stock" as the message shown on the product page when the product quantity reaches 0.'),
                    'is_featured'       => UsniAdaptor::t('productshint', 'If you want to emphasize the most important products, the Featured Products is exactly what you need.'),
                    'sku'               => UsniAdaptor::t('productshint', 'A random code for the product.'),
                    'categories'        => UsniAdaptor::t('productshint', 'Categories for the Product'),
                    'length'            => UsniAdaptor::t('productshint', 'Length for the product'),
                    'width'             => UsniAdaptor::t('productshint', 'Width for the product'),
                    'height'            => UsniAdaptor::t('productshint', 'Height for the product'),
                    'initial_quantity'  => UsniAdaptor::t('productshint', 'Initial stock for the product'),
                    'upc'               => UsniAdaptor::t('productshint','Universal Product Code'),
                    'ean'               => UsniAdaptor::t('productshint','European Article Number'),
                    'jan'               => UsniAdaptor::t('productshint','Japanese Article Number'),
                    'isbn'              => UsniAdaptor::t('productshint','International Standard Book Number'),
                    'mpn'               => UsniAdaptor::t('productshint','Manufacturer Part Number'),
               ];
    }
    
    /**
     * Get product type list
     * @return Array
     */
    public static function getProductTypeList()
    {
        return [
                   Product::TYPE_DEFAULT    => UsniAdaptor::t('products', 'Default'),
                   Product::TYPE_DOWNLOADABLE => UsniAdaptor::t('products', 'Downloadable')
               ];
    }
    
    /**
     * Get thumbnail image.
     * @param array $data
     * @return mixed
     */
    public static function getThumbnailImage($data)
    {
        return FileUploadUtil::getThumbnailImage($data, 'image', ['thumbWidth' => 50, 'thumbHeight' => 50]);
    }
}