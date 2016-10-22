<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\city\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\components\UiHtml;
use usni\library\utils\ButtonsUtil;
use usni\library\utils\DAOUtil;
use common\modules\localization\modules\country\models\Country;
/**
 * CityEditView class file
 * @package common\modules\localization\views
 */
class CityEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'          => ['type' => 'text'],
                        'country_id'    => UiHtml::getFormSelectFieldOptionsWithNoSearch(DAOUtil::getDropdownDataBasedOnModel(Country::className()),
                                                            ['closeOnSelect' => true],
                                                            ['multiple' => false])
                    ];
        $metadata = [
                        'elements'      => $elements,
                        'buttons'       => ButtonsUtil::getDefaultButtonsMetadata('localization/city/default/manage')
                    ];
        return $metadata;
    }
}
?>