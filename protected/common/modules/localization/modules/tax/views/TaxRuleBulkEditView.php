<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\views;

use usni\library\extensions\bootstrap\views\UiBootstrapBulkEditView;
use usni\library\components\UiHtml;
use usni\UsniAdaptor;
use taxes\utils\TaxUtil;
/**
 * TaxRuleBulkEditView class file
 * @package taxes\views
 */
class TaxRuleBulkEditView extends UiBootstrapBulkEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                            'based_on'              => UiHtml::getFormSelectFieldOptions(TaxUtil::getBasedOnDropdown()), //It should be dropdown.value would come from configuration.
                    ];
        $metadata = [
                        'elements'                  => $elements,
                        'buttons'                   => $this->getSubmitButton()
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('tax', 'Tax Rule Bulk Edit');
    }
}
?>