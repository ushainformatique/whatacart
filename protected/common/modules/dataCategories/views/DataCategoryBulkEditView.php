<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\dataCategories\views;

use usni\library\extensions\bootstrap\views\UiBootstrapBulkEditView;
use usni\library\components\UiHtml;
use usni\library\utils\StatusUtil;
use usni\UsniAdaptor;
/**
 * DataCategoryBulkEditView class file
 * @package common\modules\dataCategories\views
 */
class DataCategoryBulkEditView extends UiBootstrapBulkEditView
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
    protected function getTitle()
    {
        return UsniAdaptor::t('dataCategories', 'Data Category Bulk Edit');
    }
}
?>