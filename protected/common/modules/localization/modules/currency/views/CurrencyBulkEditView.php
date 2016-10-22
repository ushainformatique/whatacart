<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\views;

use usni\library\extensions\bootstrap\views\UiBootstrapBulkEditView;
use usni\library\components\UiHtml;
use usni\library\utils\StatusUtil;
use usni\UsniAdaptor;
/**
 * CurrencyBulkEditView class file
 * @package common\modules\localization\modules\currency\views
 */
class CurrencyBulkEditView extends UiBootstrapBulkEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'status'        => UiHtml::getFormSelectFieldOptionsWithNoSearch(StatusUtil::getDropdown()),
                    ];
        $metadata = [
                        'elements'          => $elements,
                        'buttons'           => $this->getSubmitButton()
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('currency', 'Currency Bulk Edit');
    }
    
    /**
     * @inheritdoc
     */
    protected function getBulkEditUrl()
    {
        $moduleId = UsniAdaptor::app()->controller->module->id;
        return UsniAdaptor::createUrl("localization/$moduleId/default/bulk-edit", ['modelClassName' => get_class($this->model)]);
    }
}
?>