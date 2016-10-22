<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;

/**
 * OrderStatusEditView class file
 * @package common\modules\localization\modules\orderstatus\views
 */
class OrderStatusEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'  => ['type' => 'text']
                    ];
        $metadata = [
            'elements'          => $elements,
            'buttons'           => ButtonsUtil::getDefaultButtonsMetadata('localization/orderstatus/default/manage')
        ];
        return $metadata;
    }
}
?>