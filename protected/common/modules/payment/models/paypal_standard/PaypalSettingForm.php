<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\models\paypal_standard;

use yii\base\Model;
/**
 * PaypalSettingForm class file.
 *
 * @package common\modules\payment\models\paypal_standard
 */
class PaypalSettingForm extends Model
{
    /**
     * PaypalSetting Model
     * @var paypalSetting
     */
    public $paypalSetting;
    
    /**
     * PaypalOrderStatus model
     * @var paypalOrderStatus 
     */
    public $paypalOrderStatus;
    
    /**
     * @inheritdoc
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
        if($this->paypalSetting == null)
        {
            $this->paypalSetting = new PaypalSetting(['scenario' => $this->scenario]);
        }
        if($this->paypalOrderStatus == null)
        {
            $this->paypalOrderStatus = new PaypalOrderStatus(['scenario' => $this->scenario]);
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
        return UsniAdaptor::t('paypal', 'Paypal Settings');
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
