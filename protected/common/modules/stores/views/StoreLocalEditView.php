<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\views;

use usni\library\components\UiHtml;
use usni\library\utils\ButtonsUtil;
use usni\library\utils\TimezoneUtil;
use usni\library\utils\CountryUtil;
use usni\library\utils\DAOUtil;
use common\modules\localization\modules\lengthclass\models\LengthClass;
use common\modules\localization\modules\weightclass\models\WeightClass;
use common\modules\localization\modules\currency\utils\CurrencyUtil;
use common\modules\stores\utils\StoreUtil;
/**
 * StoreLocalEditView class file
 *
 * @package common\modules\stores\views
 */
class StoreLocalEditView extends \usni\library\views\MultiModelEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'country'           => UiHtml::getFormSelectFieldOptions(CountryUtil::getCountries()),
                        'state'             => ['type' => 'text'],
                        'language'          => UiHtml::getFormSelectFieldOptions(StoreUtil::getLanguageDropdownData(),[], ['placeholder' => UiHtml::getDefaultPrompt()]),
                        'currency'          => UiHtml::getFormSelectFieldOptions(CurrencyUtil::getDropdownByKey('code'),[], ['placeholder' => UiHtml::getDefaultPrompt()]),
                        
                        'timezone'          => UiHtml::getFormSelectFieldOptions(TimezoneUtil::getTimezoneSelectOptions(),
                                                                           [], ['placeholder' => UiHtml::getDefaultPrompt()]),
                        'length_class'      => UiHtml::getFormSelectFieldOptions(DAOUtil::getDropdownDataBasedOnModel(LengthClass::className()),
                                                                           [], ['placeholder' => UiHtml::getDefaultPrompt()]),
                        'weight_class'      => UiHtml::getFormSelectFieldOptions(DAOUtil::getDropdownDataBasedOnModel(WeightClass::className()),
                                                                           [], ['placeholder' => UiHtml::getDefaultPrompt()]),
                        
                    ];
        $metadata = [
                        'elements'          => $elements,
                        'buttons'           => ButtonsUtil::getDefaultButtonsMetadata("stores/default/manage")
                    ];
        return $metadata;
    }
}
