<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\weightclass\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;

/**
 * WeightClassEditView class file
 * @package common\modules\localization\modules\weightclass\views
 */
class WeightClassEditView extends UiBootstrapEditView
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
            'buttons'           => ButtonsUtil::getDefaultButtonsMetadata('localization/weightclass/default/manage')
        ];
        return $metadata;
    }
}
?>