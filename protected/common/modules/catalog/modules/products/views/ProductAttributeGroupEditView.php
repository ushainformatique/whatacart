<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
/**
 * ProductAttributeGroupEditView class file
 * @package products\views
 */
class ProductAttributeGroupEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'          => ['type' => 'text'],
                        'sort_order'    => ['type' => 'text']
                     ];
        $metadata =  [
                        'elements' => $elements,
                        'buttons'  => ButtonsUtil::getDefaultButtonsMetadata('catalog/products/attribute-group/manage')
                     ];
        return $metadata;
    }
}
?>