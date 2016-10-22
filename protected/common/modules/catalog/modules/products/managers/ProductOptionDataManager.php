<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\managers;

use usni\library\components\UiDataManager;
use products\models\ProductOption;
use products\utils\ProductUtil;
/**
 * Loads default data related to product option.
 *
 * @package products\managers
 */
class ProductOptionDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return ProductOption::className();
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
        return [
                    [
                        'name'          => 'Color',
                        'display_name'  => 'color',
                        'sort_order'    => 1,
                        'type'          => 'checkbox',
                        'url'           => 'http://xyz.com'
                    ],
                    [
                        'name'          => 'Size',
                        'display_name'  => 'size',
                        'sort_order'    => 2,
                        'type'          => 'radio',
                        'url'           => 'http://xyz.com'
                    ],
                    [
                        'name'          => 'Resolution',
                        'display_name'  => 'resolution',
                        'sort_order'    => 3,
                        'type'          => 'select',
                        'url'           => 'http://xyz.com'
                    ],
                ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getDefaultDemoDataSet()
    {
        return [];
    }
    
    /**
     * @inheritdoc
     */
    public static function loadDefaultData()
    {
        if(parent::loadDefaultData())
        {
            $postData       = [];
            $options        = ProductOption::find()->all();
            //For color
            $optionValues   = ['Grey', 'Silver', 'Black'];
            $postData['ProductOptionValue']['value'] = $optionValues;
            ProductUtil::saveOptionValue($options[0], 'create', $postData);
            //For size
            $optionValues   = ['L', 'M', 'XL', 'S'];
            $postData['ProductOptionValue']['value'] = $optionValues;
            ProductUtil::saveOptionValue($options[1], 'create', $postData);

            //For resolution
            $optionValues   = ['4MP', '8MP', '10MP'];
            $postData['ProductOptionValue']['value'] = $optionValues;
            ProductUtil::saveOptionValue($options[2], 'create', $postData);
            return true;
        }
        return false;
    }
}