<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\views;

use usni\library\modules\users\views\AddressEditView;
use usni\library\utils\ArrayUtil;
/**
 * ShippingAddressEditView class file
 *
 * @package common\modules\stores\views
 */
class ShippingAddressEditView extends AddressEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = ['useBillingAddress' => ['type' => 'checkbox']];
        $metadata = parent::getFormBuilderMetadata();
        $metadata['elements'] = ArrayUtil::merge($elements, $metadata['elements']);
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        return array(
            'useBillingAddress' => array(
                    'options' => [],
                    'horizontalCheckboxTemplate' => "<div class=\"checkbox checkbox-admin\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}"
            )
        );
    }
}
