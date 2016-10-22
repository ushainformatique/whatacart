<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\components\UiHtml;
use usni\library\utils\ButtonsUtil;
use usni\library\utils\StatusUtil;
/**
 * CountryEditView class file
 * @package common\modules\localization\modules\country\views
 */
class CountryEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'              => ['type' => 'text'],
                        'iso_code_2'        => ['type' => 'text'],
                        'iso_code_3'        => ['type' => 'text'],
                        'address_format'    => ['type' => 'textarea'],
                        'postcode_required' => ['type' => 'checkbox'],
                        'status'            => UiHtml::getFormSelectFieldOptionsWithNoSearch(StatusUtil::getDropdown()),
                    ];
        $metadata = [
                        'elements'          => $elements,
                        'buttons'           => ButtonsUtil::getDefaultButtonsMetadata('/localization/country/default/manage')
                    ];
        return $metadata;
    }
}
?>