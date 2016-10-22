<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use usni\library\components\UiHtml;
use usni\UsniAdaptor;
use products\models\ProductOption;
use products\utils\ProductUtil;
use usni\library\utils\ArrayUtil;
/**
 * AssignProductOptionsListView class file
 *
 * @package products\views
 */
class AssignProductOptionsListView extends \usni\library\views\UiView
{
    /**
     * Product model associated with the view.
     * @var Product 
     */
    public $product;
    
    /**
     * Should render action columns or not
     * @var type 
     */
    public $shouldRenderActionColumn = true;
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $content = null;
        $records    = ProductUtil::getAssignedOptions($this->product->id, UsniAdaptor::app()->languageManager->getContentLanguage());
        $modifiedRecords = [];
        foreach($records as $record)
        {
            if(ArrayUtil::keyExists($record['optionId'], $modifiedRecords) === false)
            {
                $modifiedRecords[$record['optionId']] = [
                                                            'display_name'  => $record['display_name'],
                                                            'required'      => $record['required'],
                                                            'type'          => $record['type'],
                                                            'sort_order'    => $record['sort_order']
                                                        ];
            }
            $optionValue  = [
                'id'              => $record['id'], //product option mapping id
                'option_value_id' => $record['optionValueId'],
                'option_value_name'  => $record['value'],
                'weight'        => $record['weight'],
                'weight_prefix' => $record['weight_prefix'],
                'price'         => $record['price'],
                'price_prefix'  => $record['price_prefix'],
                'quantity'      => $record['quantity'],
                'subtract_stock' => $record['subtract_stock'],
            ];
            $modifiedRecords[$record['optionId']]['optionValues'][] = $optionValue;
        }
        if(!empty($modifiedRecords))
        {
            foreach($modifiedRecords as $modifiedRecord)
            {
                $isRequired    = $modifiedRecord['required'] ? UsniAdaptor::t('application', 'Yes') : UsniAdaptor::t('application', 'No');
                $optionLabel = UiHtml::tag('strong', ProductOption::getLabel(1)) .  ': ' . $modifiedRecord['display_name'] . ' ' . 
                               UiHtml::tag('strong', UsniAdaptor::t('products', 'Required')) . ': ' . $isRequired . ' ' .
                               UiHtml::tag('strong', UsniAdaptor::t('application', 'Sort Order')) . ': ' . $modifiedRecord['sort_order'];
                $column     = UiHtml::tag('td', $optionLabel, ['colspan' => 5]);
                $content    .= UiHtml::tag('tr', $column);
                $content    .= $this->renderRows($modifiedRecord);
            }
        }
        else
        {
            $content .= "<tr><td colspan='6'>" . UsniAdaptor::t('application', 'No results found') . "</td></tr>";
        }
        $filePath   = UsniAdaptor::getAlias('@products/views/_manageOptionValues') . '.php';
        return $this->getView()->renderPhpFile($filePath, ['rows' => $content]);
    }
    
    /**
     * Renders option values rows.
     * @param ProductOption $option
     * @return string
     */
    protected function renderRows($option)
    {
        $content      = null;
        $optionValues = $option['optionValues']; 
        foreach($optionValues as $index => $optionValueRecord)
        {
            $includeHeader = false;
            if($index == 0)
            {
                $includeHeader = true;
            }
            $deleteUrl  = UsniAdaptor::createUrl('catalog/products/option/remove');
            $filePath   = UsniAdaptor::getAlias('@products/views/_optionValueAssignedRow') . '.php';
            $content    .= $this->getView()->renderPhpFile($filePath, ['optionValueRecord' => $optionValueRecord, 
                                                                       'includeHeader' => $includeHeader, 'deleteUrl' => $deleteUrl,
                                                                       'shouldRenderActionColumn' => $this->shouldRenderActionColumn]);
        }
        return $content;
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        $script = "$.fn.extend({
                    removeProductOption:function(url, productOptionMappingId)
                    {
                        $.ajax({
                                url: url,
                                type: 'get',
                                data: 'mappingId=' + productOptionMappingId,
                                dataType: 'json',
                                success: function(json) {	
                                }
                            });
                    }
                    })";
        $this->getView()->registerJs($script);
    }
}
?>