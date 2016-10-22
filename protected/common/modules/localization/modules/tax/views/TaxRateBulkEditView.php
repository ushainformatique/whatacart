<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\views;

use usni\library\extensions\bootstrap\views\UiBootstrapBulkEditView;
use usni\library\components\UiHtml;
use usni\library\utils\DAOUtil;
use taxes\models\Zone;
use usni\UsniAdaptor;
use taxes\utils\TaxUtil;
/**
 * TaxRateBulkEditView class file
 * @package taxes\views
 */
class TaxRateBulkEditView extends UiBootstrapBulkEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'tax_zone_id'   => UiHtml::getFormSelectFieldOptionsWithNoSearch(DAOUtil::getDropdownDataBasedOnModel(Zone::className())),
                        'type'          => UiHtml::getFormSelectFieldOptionsWithNoSearch(TaxUtil::getTaxTypeDropdown())
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
        return UsniAdaptor::t('tax', 'Tax Rate Bulk Edit');
    }
}
?>