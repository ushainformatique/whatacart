<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views;

use usni\library\utils\ButtonsUtil;
/**
 * OrderAddressEditView class file.
 * @package common\modules\order\views
 */
class OrderAddressEditView extends \usni\library\extensions\bootstrap\views\UiBootstrapEditView
{

    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'firstname'     => ['type' => 'text'],
                        'lastname'      => ['type' => 'text'],
                        'email'         => ['type' => 'text'],
                        'mobilephone'   => ['type' => 'text'],
                        'address1'      => ['type' => 'text'],
                        'address2'      => ['type' => 'text'],
                        'city'          => ['type' => 'text'],
                        'country'       => ['type' => 'text'],
                        'state'         => ['type' => 'text'],
                        //Should be dropdown
                        'type'          => ['type' => 'text'],
                        'postal_code'   => ['type' => 'text'],
                        
                    ];
        $metadata = [
                        'elements'  => $elements,
                        'buttons'   => ButtonsUtil::getDefaultButtonsMetadata('order/default/manage')
                    ];
        return $metadata;
    }
}
?>