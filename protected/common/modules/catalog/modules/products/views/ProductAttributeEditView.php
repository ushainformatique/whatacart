<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
use usni\library\components\UiHtml;
use products\models\ProductAttributeGroup;
use usni\library\utils\DAOUtil;
/**
 * ProductAttributeEditView class file
 * @package products\views
 */
class ProductAttributeEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'              => ['type' => 'text'],
                        'sort_order'        => ['type' => 'text'],
                        'attribute_group'   => UiHtml::getFormSelectFieldOptions(DAOUtil::getDropdownDataBasedOnModel(ProductAttributeGroup::className())),
                     ];
        $metadata =  [
                        'elements' => $elements,
                        'buttons'  => ButtonsUtil::getDefaultButtonsMetadata('catalog/products/attribute/manage')
                     ];
        return $metadata;
    }
}
?>