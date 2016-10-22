<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\lengthclass\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
/**
 * LengthClassEditView class file
 * @package common\modules\localization\modules\lengthclass\views
 */
class LengthClassEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'  => ['type' => 'text'],
                        'unit'  => ['type' => 'text'],
                        'value' => ['type' => 'text'],
                    ];
        $metadata = [
                        'elements'          => $elements,
                        'buttons'           => ButtonsUtil::getDefaultButtonsMetadata('localization/lengthclass/default/manage')
                    ];
        return $metadata;
    }
}
?>