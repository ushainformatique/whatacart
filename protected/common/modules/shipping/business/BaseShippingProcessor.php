<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\business;

use usni\UsniAdaptor;
/**
 * Base class for shipping processor.
 * 
 * @package common\modules\shipping\business
 */
abstract class BaseShippingProcessor extends \yii\base\Component
{   
    /**
     * @var int 
     */
    public $selectedStoreId;
    
    /**
     * @var string 
     */
    public $language;
    
    /**
     * @var string 
     */
    public $selectedCurrency;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        $this->selectedStoreId  = UsniAdaptor::app()->storeManager->selectedStoreId;
        $this->language = UsniAdaptor::app()->languageManager->selectedLanguage;
        $this->selectedCurrency  = UsniAdaptor::app()->currencyManager->selectedCurrency;
    }
    
    /**
     * Get calculate price for the shipping
     * @param Cart $cart
     */
    abstract public function getCalculatedPrice($cart);
    
    /**
     * Get dropdown description for the shipping
     */
    abstract public function getDescription();
}
