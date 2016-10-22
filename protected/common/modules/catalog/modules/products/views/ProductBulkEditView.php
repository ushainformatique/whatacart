<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use usni\library\extensions\bootstrap\views\UiBootstrapBulkEditView;
use usni\library\components\UiHtml;
use usni\library\utils\StatusUtil;
use usni\UsniAdaptor;
/**
 * ProductBulkEditView class file
 * @package products\views
 */
class ProductBulkEditView extends UiBootstrapBulkEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'status'    => UiHtml::getFormSelectFieldOptionsWithNoSearch(StatusUtil::getDropdown()),
                    ];

        $metadata = [
                        'elements'  => $elements,
                        'buttons'   => $this->getSubmitButton()
                    ];
        return $metadata;
    }

    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return UsniAdaptor::t('products', 'Product Bulk Edit');
    }
}
