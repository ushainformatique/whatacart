<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */ 
namespace common\modules\shipping\models\flat;

use yii\base\Model;
use usni\UsniAdaptor;
use common\modules\shipping\utils\flat\FlatShippingUtil;
/**
 * FlatRateEditForm class file
 * @package common\modules\shipping\models\flat
 * @see http://merch.docs.magento.com/ce/user_guide-Jan-29/content/shipping/flat-rate.html
 */
class FlatRateEditForm extends Model
{
    /**
     * Method name for the flat rate displayed
     * @var string 
     */
    public $method_name;
    
    /**
     * Calculate handling fee type= percent or fixed
     * @var string 
     */
    public $calculateHandlingFee;
    
    /**
     * Handling fee
     * @var float 
     */
    public $handlingFee;
    
    /**
     * Price for flat rate shipping
     * @var Price 
     */
    public $price;
    
    /**
     * This would be a dropdown having per item, per order, none means free shipping
     * @var string 
     */
    public $type;
    
    /**
     * Ship to applicable zones(All Zones or Specific Zones)
     * @var int 
     */
    public $applicableZones;
    
    /**
     * Ship to specific zones
     * @var array 
     */
    public $specificZones;

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('shipping', 'Flat Rate');
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'method_name', 'type'], 'required'],
            [['price', 'method_name', 'type', 'calculateHandlingFee', 'handlingFee', 'applicableZones', 'specificZones'], 'safe'],
            ['price', 'match', 'pattern'=>'/^[0-9]{1,12}(\.[0-9]{0,4})?$/'],
            ['specificZones', 'required', 
                    'whenClient' => "function(attribute, value){
                        return $('#flatrateeditform-applicablezones').val() != '1';
                     }", 
                    'when' => [$this, 'validateSpecificZones']
                    ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['create']     = $scenario['update'] = ['price', 'method_name', 'type', 'calculateHandlingFee', 'handlingFee', 'applicableZones', 'specificZones'];
        $scenario['bulkedit']   = ['status'];
        return $scenario;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'price'     => UsniAdaptor::t('products', 'Price'),
            'method_name' => UsniAdaptor::t('shipping', 'Method Name'),
            'type'      => UsniAdaptor::t('application', 'Type'),
            'calculateHandlingFee' => UsniAdaptor::t('shipping', 'Calculate Handling Fee'),
            'handlingFee'  => UsniAdaptor::t('shipping', 'Handling Fee'),
            'applicableZones' => UsniAdaptor::t('shipping', 'Applicable Zones'),
            'specificZones'   => UsniAdaptor::t('shipping', 'Specific Zones')
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'price'     => UsniAdaptor::t('productshint', 'Price of the shipping'),
            'method_name' => UsniAdaptor::t('shippinghint', 'Method name for shipping. It could be Fixed or Plus Handling as suitable'),
            'type'      => UsniAdaptor::t('shippinghint', 'Type of flat rate i.e per order, per item or none'),
            'calculateHandlingFee' => UsniAdaptor::t('shippinghint', 'Calculate handling fees type fixed or percent'),
            'handlingFee'  => UsniAdaptor::t('shippinghint', 'Handling Fee, fixed or percent. If percent for example 6% equals .06'),
            'applicableZones' => UsniAdaptor::t('shippinghint', 'Zones to which the shipping would be applied. All zones or specific zones.'),
            'specificZones'   => UsniAdaptor::t('shippinghint', 'Specific zones to which the shipping is applied')
        ];
    }
    
    /**
     * Validate the specific zones.
     * @param string $attribute Attribute having user attribute related to login.
     * @param array  $params
     * @return void
     */
    public function validateSpecificZones($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            if($this->applicableZones != FlatShippingUtil::SHIP_TO_ALL_ZONES)
            {
                if($this->specificZones == null)
                {
                    $this->addError('specificZones', UsniAdaptor::t('tax', 'Specific zones is required.'));
                }
            }            
        }
    }
}