<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use common\modules\shipping\utils\ShippingUtil;
/**
 * DeliveryOptionsEditView class file.
 * 
 * @package cart\views
 */
class DeliveryOptionsEditView extends \usni\library\views\MultiModelEditView
{
    /**
     * Application end into which view is loaded
     * @var string 
     */
    public $source;
    
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $shippingMethods = ShippingUtil::getMethods();
        if($this->model->shipping == null)
        {
            $keys = array_keys($shippingMethods);
            $this->model->shipping = $keys[0];
        }
        $elements = array(
            'shipping'      => ['type' => 'radioList', 'items' => ShippingUtil::getMethods()],
        );
        $metadata = array(
            'elements'              => $elements,
        );
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function getDefaultAttributeTemplate()
    {
        return "{beginWrapper}\n{input}\n{error}\n{endWrapper}";
    }
}