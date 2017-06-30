<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\utils;

use usni\UsniAdaptor;
use usni\library\utils\Html;
use usni\library\utils\FileUploadUtil;
/**
 * ProductCategoryUtil class file.
 * 
 * @package productCategories\utils
 */
class ProductCategoryUtil
{
    /**
     * Get items per page options.
     * @return Array
     */
    public static function getItemsPerPageOptions()
    {
        return [
                    9   => 9,
                    18  => 18,
                    27  => 27,
                    36  => 36,
                    45  => 45,
                    54  => 54,
                    63  => 63
               ];
    }
    
    /**
     * Get sorting options for products.
     * @return Array
     */
    public static function getSortingOptions()
    {
        return [
                    ''          => Html::getDefaultPrompt(),
                    'nameasc'   => UsniAdaptor::t('products', 'Name(A-Z)'),
                    'namedesc'  => UsniAdaptor::t('products', 'Name(Z-A)'),
                    'priceasc'  => UsniAdaptor::t('products', 'Price(Low > High)'),
                    'pricedesc' => UsniAdaptor::t('products', 'Price(High > Low)'),
               ];
    }
    
    /**
     * Get display in  top menu.
     * @param boolean $displayInTopMenu
     * @return string
     */
    public static function getDisplayInTopMenu($displayInTopMenu)
    {
        if($displayInTopMenu == true)
        {
            return UsniAdaptor::t('application', 'Yes');
        }
        return UsniAdaptor::t('application', 'No');
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