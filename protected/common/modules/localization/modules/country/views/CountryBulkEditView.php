<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\views;

use usni\library\extensions\bootstrap\views\UiBootstrapBulkEditView;
use usni\library\components\UiHtml;
use usni\library\utils\StatusUtil;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
/**
 * CountryBulkEditView class file
 * 
 * @package common\modules\localization\modules\country\views
 */
class CountryBulkEditView extends UiBootstrapBulkEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'status'            => UiHtml::getFormSelectFieldOptionsWithNoSearch(StatusUtil::getDropdown()),
                        'postcode_required' => UiHtml::getFormSelectFieldOptionsWithNoSearch(AdminUtil::getYesNoOptions()),
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
        return UsniAdaptor::t('country', 'Country Bulk Edit');
    }
}