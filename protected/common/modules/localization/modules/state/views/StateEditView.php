<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\components\UiHtml;
use usni\library\utils\ButtonsUtil;
use usni\library\utils\DAOUtil;
use common\modules\localization\modules\country\models\Country;
use usni\library\utils\StatusUtil;
/**
 * StateEditView class file
 * @package common\modules\localization\modules\state\views
 */
class StateEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'        => ['type' => 'text'],
                        'code'        => ['type' => 'text'],
                        'country_id'  => UiHtml::getFormSelectFieldOptions(DAOUtil::getDropdownDataBasedOnModel(Country::className()),
                                                        ['closeOnSelect' => true],
                                                        ['multiple' => false]),
                        'status'      => UiHtml::getFormSelectFieldOptionsWithNoSearch(StatusUtil::getDropdown()),
                    ];
        $metadata = [
                        'elements'    => $elements,
                        'buttons'     => ButtonsUtil::getDefaultButtonsMetadata('localization/state/default/manage')
                    ];
        return $metadata;
    }
}
?>