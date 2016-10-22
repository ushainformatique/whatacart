<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\components\UiHtml;
use usni\library\utils\StatusUtil;
use usni\library\utils\ButtonsUtil;

/**
 * CurrencyEditView class file
 * @package common\modules\localization\modules\currency\views
 */
class CurrencyEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'          => array('type' => 'text'),
                        'code'          => array('type' => 'text'),
                        'symbol_left'   => array('type' => 'text'),
                        'symbol_right'  => array('type' => 'text'),
                        'decimal_place' => array('type' => 'text'),
                        'value'         => array('type' => 'text'),
                        'status'        => UiHtml::getFormSelectFieldOptionsWithNoSearch(StatusUtil::getDropdown()),
                    ];
        $metadata = [
                        'elements'          => $elements,
                        'buttons'           => ButtonsUtil::getDefaultButtonsMetadata('localization/currency/default/manage')
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveDefaultBrowseByAttribute()
    {
        return 'name';
    }
}
?>