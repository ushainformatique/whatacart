<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\business;

use usni\UsniAdaptor;
/**
 * Manager class file.
 *
 * @package common\business
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * @var int selected store id 
     */
    public $selectedStoreId;
    /**
     * @var string 
     */
    public $selectedCurrency;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->selectedStoreId  = UsniAdaptor::app()->storeManager->selectedStoreId;
        $this->selectedCurrency = UsniAdaptor::app()->currencyManager->selectedCurrency;
    }
}
