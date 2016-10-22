<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
use usni\library\components\UiActiveForm;
use marqu3s\summernote\Summernote;
/**
 * ProductTaxClassEditView class file.
 * @package taxes\views
 */
class ProductTaxClassEditView extends UiBootstrapEditView
{

    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'        => ['type' => 'text'],
                        'description' => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => Summernote::className()],
                    ];
        $metadata = [
                        'elements'          => $elements,
                        'buttons'           => ButtonsUtil::getDefaultButtonsMetadata('localization/tax/product-tax-class/manage')
                    ];
        return $metadata;
    }
}
?>