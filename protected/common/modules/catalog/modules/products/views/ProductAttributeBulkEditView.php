<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use usni\library\extensions\bootstrap\views\UiBootstrapBulkEditView;
use usni\library\components\UiHtml;
use products\models\ProductAttributeGroup;
use usni\library\utils\DAOUtil;
use usni\UsniAdaptor;
/**
 * ProductAttributeBulkEditView class file
 * @package products\views
 */
class ProductAttributeBulkEditView extends UiBootstrapBulkEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements =  [
                        'attribute_group'   => UiHtml::getFormSelectFieldOptions(DAOUtil::getDropdownDataBasedOnModel(ProductAttributeGroup::className())),
                     ];
        $metadata =  [
                        'elements' => $elements,
                        'buttons'  => $this->getSubmitButton()
                     ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('products', 'Attribute Bulk Edit');
    }
}
?>