<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\components;

/**
 * ShippingFactory class file.
 * 
 * @package common\modules\shipping\components
 */
class ShippingFactory extends \yii\base\Component
{
    /**
     * Type of shipping
     * @var string 
     */
    public $type;
    
    /**
     * Get instance
     * @return Object
     */
    public function getInstance()
    {
        $className  = '\common\modules\shipping\business\\' . $this->type . '\ShippingProcessor';
        return new $className();
    }
}