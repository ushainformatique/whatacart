<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\views;

use usni\library\extensions\bootstrap\views\UiBootstrapBulkEditView;
use usni\library\components\UiHtml;
use common\modules\cms\utils\DropdownUtil;
use usni\UsniAdaptor;
/**
 * PageBulkEditView class file
 * @package common\modules\cms\views
 */
class PageBulkEditView extends UiBootstrapBulkEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'parent_id'    => UiHtml::getFormSelectFieldOptions($this->model->getMultiLevelSelectOptions('name', 0, '-', true, $this->shouldRenderOwnerCreatedModels())),
                        'status'       => UiHtml::getFormSelectFieldOptionsWithNoSearch(DropdownUtil::getStatusSelectOptions()),
                    ];

        $metadata = [
                        'elements'      => $elements,
                        'buttons'       => $this->getSubmitButton()
                    ];

        return $metadata;
    }

    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return UsniAdaptor::t('cms', 'Page Bulk Edit');
    }

}
