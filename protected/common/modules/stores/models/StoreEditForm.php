<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */ 
namespace common\modules\stores\models;

use yii\base\Model;
use usni\UsniAdaptor;
use common\modules\stores\models\Store;
use common\models\BillingAddress;
use common\models\ShippingAddress;
use common\modules\stores\models\StoreLocal;
use common\modules\stores\models\StoreSettings;
use common\modules\stores\models\StoreImage;
/**
 * StoreEditForm class file
 * 
 * @package common\modules\stores\models
 */
class StoreEditForm extends Model
{
    /**
     * @var Store 
     */
    public $store;
    
    /**
     * @var BillingAddress 
     */
    public $billingAddress;
    
    /**
     * @var ShippingAddress 
     */
    public $shippingAddress;
    
    /**
     * @var StoreLocal 
     */
    public $storeLocal;
    
    /**
     * @var StoreSettings 
     */
    public $storeSettings;
    
    /**
     * @var StoreImage 
     */
    public $storeImage;
    
    /**
     * @inheritdoc
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
        if($this->store == null)
        {
            $this->store = new Store(['scenario' => $this->scenario]);
        }
        if($this->billingAddress == null)
        {
            $this->billingAddress = new BillingAddress(['scenario' => $this->scenario]);
        }
        if($this->shippingAddress == null)
        {
            $this->shippingAddress = new ShippingAddress(['scenario' => $this->scenario]);
        }
        if($this->storeLocal == null)
        {
            $this->storeLocal = new StoreLocal(['scenario' => $this->scenario]);
        }
        if($this->storeSettings == null)
        {
            $this->storeSettings = new StoreSettings(['scenario' => $this->scenario]);
        }
        if($this->storeImage == null)
        {
            $this->storeImage = new StoreImage(['scenario' => $this->scenario]);
        }
    }
    
    /**
     * Validation rules for the model.
     * @return array Validation rules for model attributes.
     */
    public function rules()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('stores', 'Store') : UsniAdaptor::t('stores', 'Stores');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [];
    }
}
