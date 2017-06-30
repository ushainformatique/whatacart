<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\DataManager;
use products\models\ProductOption;
use products\business\ProductOptionManager;
use usni\UsniAdaptor;
use usni\library\modules\users\models\User;
/**
 * Loads default data related to product option.
 *
 * @package products\db
 */
class ProductOptionDataManager extends DataManager
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
    public function getDefaultDataSet()
    {
        return [
                    [
                        'name'          => UsniAdaptor::t('products', 'Color'),
                        'display_name'  => UsniAdaptor::t('products', 'color'),
                        'sort_order'    => 1,
                        'type'          => 'checkbox',
                        'url'           => 'http://xyz.com'
                    ],
                    [
                        'name'          => UsniAdaptor::t('products', 'Size'),
                        'display_name'  => UsniAdaptor::t('products', 'size'),
                        'sort_order'    => 2,
                        'type'          => 'radio',
                        'url'           => 'http://xyz.com'
                    ],
                    [
                        'name'          => UsniAdaptor::t('products', 'Resolution'),
                        'display_name'  => UsniAdaptor::t('products', 'resolution'),
                        'sort_order'    => 3,
                        'type'          => 'select',
                        'url'           => 'http://xyz.com'
                    ],
                ];
    }
    
    /**
     * @inheritdoc
     */
    public function loadDefaultData()
    {
        if(parent::loadDefaultData())
        {
            $manager    = ProductOptionManager::getInstance(['userId' => User::SUPER_USER_ID]);
            $options    = ProductOption::find()->all();
            //For color
            $postData    = [
                                ['value' => 'Grey', 'id' => -1],
                                ['value' => 'Silver', 'id' => -1],
                                ['value' => 'Black', 'id' => -1]
                           ];
            $manager->saveOptionValues($options[0], $postData);
            //For size
            $postData    = [
                                ['value' => 'L', 'id' => -1],
                                ['value' => 'M', 'id' => -1],
                                ['value' => 'XL', 'id' => -1],
                                ['value' => 'S', 'id' => -1]
                           ];
            $manager->saveOptionValues($options[1], $postData);

            //For resolution
            $postData    = [
                                ['value' => '4MP', 'id' => -1],
                                ['value' => '8MP', 'id' => -1],
                                ['value' => '10MP', 'id' => -1]
                           ];
            $manager->saveOptionValues($options[2], $postData);
            return true;
        }
        return false;
    }
}