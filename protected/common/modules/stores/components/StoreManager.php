<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\components;

use usni\library\utils\ArrayUtil;

/**
 * Global application component related to store.
 *
 * @package common\modules\stores\components
 */
class StoreManager extends \yii\base\Component
{
    use \common\modules\stores\traits\StoreConfigTrait;
    
    /**
     * @var array List of stores available 
     */
    public $stores;
    
    /**
     * Selected store
     * @var array 
     */
    public $selectedStore;
    
    /**
     * Selected store id
     * @var int 
     */
    public $selectedStoreId;
    
    /**
     * Store configuration for the selected store
     * @var array 
     */
    public $config;
    
    /**
     * Get allowed stores.
     * @return array
     */
    public function getAllowed()
    {
        return ArrayUtil::map($this->stores, 'id', 'name');
    }
}