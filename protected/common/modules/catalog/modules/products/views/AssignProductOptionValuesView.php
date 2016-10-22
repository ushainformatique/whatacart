<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use usni\library\views\UiView;
use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use usni\library\components\UiHtml;
use products\utils\ProductUtil;
/**
 * Assign product option values
 * @package products\views
 */
class AssignProductOptionValuesView extends UiView
{
    /**
     * Option id for which values have to be configured.
     * @var ProductOption 
     */
    public $optionId;
    
    /**
     * Product option mappings.
     * @var array
     */
    public $optionMappings = [];
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $optionValues = ProductUtil::getProductOptionValues($this->optionId);
        $assignedOptionMapping = $this->optionMappings;
        $filePath     = UsniAdaptor::getAlias('@products/views/_assignOptionValuesRow') . '.php';
        $mainFilePath = UsniAdaptor::getAlias('@products/views/_assignOptionValues') . '.php';
        $dummyFilePath = UsniAdaptor::getAlias('@products/views/_assignOptionValuesDummy') . '.php';
        $rowContent   = null;
        $items        = ArrayUtil::map($optionValues, 'id', 'value');
        foreach($assignedOptionMapping as $index => $optionMapping)
        {
            $dropdown   = UiHtml::dropDownList('ProductOptionMapping[option_value_id][]', $optionMapping['option_value_id'], $items, ['class' => 'form-control']);
            $rowContent .= $this->getView()->renderPhpFile($filePath, ['dropdown' => $dropdown,
                                                                       'quantity' => $optionMapping['quantity'],
                                                                       'subtract_stock' => $optionMapping['subtract_stock'],
                                                                       'price_prefix' => $optionMapping['price_prefix'],
                                                                       'price'        => $optionMapping['price'],
                                                                       'weight_prefix'=> $optionMapping['weight_prefix'],
                                                                       'weight'       => $optionMapping['weight'],
                                                                       'index' => $index]);
        }
        $content  = $this->getView()->renderPhpFile($mainFilePath, ['rows' => $rowContent]);
        $dummyDropdown = UiHtml::dropDownList('ProductOptionMapping[option_value_id_dummy][]', null, $items, ['class' => 'form-control dummy-option']);
        $content  .= $this->getView()->renderPhpFile($dummyFilePath, ['dropdown' => $dummyDropdown]);
        return $content;
    }
}