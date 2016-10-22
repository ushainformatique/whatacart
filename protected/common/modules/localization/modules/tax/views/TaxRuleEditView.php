<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
use taxes\models\ProductTaxClass;
use customer\utils\CustomerUtil;
use taxes\models\TaxRate;
use taxes\utils\TaxUtil;
use usni\library\components\UiHtml;
use usni\library\utils\DAOUtil;
/**
 * TaxRuleEditView class file
 * @package taxes\views
 */
class TaxRuleEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                            'name'                  => ['type' => 'text'],
                            'productTaxClass'       => UiHtml::getFormSelectFieldOptions(DAOUtil::getDropdownDataBasedOnModel(ProductTaxClass::className()),
                                                            ['closeOnSelect' => true],
                                                            ['multiple'      => true]),
                            'based_on'              => UiHtml::getFormSelectFieldOptions(TaxUtil::getBasedOnDropdown(),
                                                            ['closeOnSelect' => true],
                                                            ['multiple'      => false]),
                            'customerGroups'        => UiHtml::getFormSelectFieldOptions(CustomerUtil::getCustomerGroupDropdownData(),
                                                            ['closeOnSelect' => true],
                                                            ['multiple'      => true]),
                            'taxRates'              => UiHtml::getFormSelectFieldOptions(TaxUtil::getDropdownDataBasedOnModel(TaxRate::className()),
                                                            ['closeOnSelect' => true],
                                                            ['multiple'      => true]),
                    ];
        $metadata = [
                        'elements'          => $elements,
                        'buttons'           => ButtonsUtil::getDefaultButtonsMetadata('localization/tax/tax-rule/manage')
                    ];
        return $metadata;
    }
}
?>