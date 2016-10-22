<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
use usni\library\components\UiHtml;
use usni\library\utils\DAOUtil;
use taxes\models\Zone;
use taxes\utils\TaxUtil;
/**
 * TaxRateEditView class file
 * @package taxes\views
 */
class TaxRateEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'          => ['type' => 'text'],
                        'type'          => UiHtml::getFormSelectFieldOptionsWithNoSearch(TaxUtil::getTaxTypeDropdown()),
                        'value'         => ['type' => 'text'],
                        'tax_zone_id'   => UiHtml::getFormSelectFieldOptionsWithNoSearch(DAOUtil::getDropdownDataBasedOnModel(Zone::className())),
                    ];
        $metadata = [
                        'elements'          => $elements,
                        'buttons'           => ButtonsUtil::getDefaultButtonsMetadata('localization/tax/tax-rate/manage')
                    ];
        return $metadata;
    }
}
?>