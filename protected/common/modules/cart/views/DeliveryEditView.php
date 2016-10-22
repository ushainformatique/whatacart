<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use usni\library\utils\ArrayUtil;
use cart\utils\CartUtil;
/**
 * DeliveryEditView class file.
 * 
 * @package cart\views
 */
class DeliveryEditView extends BillingEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = ['sameAsBillingAddress' => ['type' => 'checkbox']];
        $metadata = parent::getFormBuilderMetadata();
        $metadata['elements'] = ArrayUtil::merge($elements, $metadata['elements']);
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        CartUtil::registerSameAsBillingAddressScript($this->getView());
    }
    
    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        if($this->source == 'admin')
        {
            return array(
                'sameAsBillingAddress' => array(
                        'options' => [],
                        'checkboxTemplate' => "<div class=\"checkbox checkbox-admin\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}"
                )
            );
        }
        return parent::attributeOptions();
    }
}