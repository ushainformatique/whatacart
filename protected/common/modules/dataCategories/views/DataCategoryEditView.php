<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\dataCategories\views;

use usni\library\utils\ButtonsUtil;
use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\components\UiActiveForm;
use usni\library\components\UiHtml;
use usni\library\utils\StatusUtil;
use marqu3s\summernote\Summernote;

/**
 * DataCategoryEditView class file
 * @package common\modules\dataCategories\views
 */
class DataCategoryEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'          => ['type' => 'text'],
                        'description'   => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => Summernote::className()],
                        'status'        => UiHtml::getFormSelectFieldOptionsWithNoSearch(StatusUtil::getDropdown()),
                    ];
        $metadata = [
            'elements'          => $elements,
            'buttons'           => ButtonsUtil::getDefaultButtonsMetadata("dataCategories/default/manage")
        ];
        return $metadata;
    }
}
?>