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
use customer\utils\CustomerUtil;
use products\utils\ProductUtil;
/**
 * Special view for the product.
 *
 * @package products\views
 */
class SpecialView extends UiView
{
    /**
     * Product for which option values have to be configured.
     * @var Product
     */
    public $product;
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $availableCustomerGroups    = CustomerUtil::getChildCustomerGroups();
        $productSpecials            = ProductUtil::getProductSpecials($this->product->id);
        $filePath                   = $this->getFilePath();
        $mainFilePath               = $this->getMainFilePath();
        $dummyFilePath              = UsniAdaptor::getAlias('@products/views/_productSpecialDummy') . '.php';
        $rowContent                 = null;
        $items                      = ArrayUtil::map($availableCustomerGroups, 'id', 'name');
        foreach($productSpecials as $index => $productSpecial)
        {
            $dropdown   = UiHtml::dropDownList('ProductSpecial[group_id][]', $productSpecial['group_id'], $items, ['class' => 'form-control']);
            $rowContent .= $this->getView()->renderPhpFile($filePath, ['dropdown' => $dropdown,
                                                                       'priority' => $productSpecial['priority'],
                                                                       'price'    => $productSpecial['price'],
                                                                       'start_datetime' => $productSpecial['start_datetime'],
                                                                       'end_datetime'   => $productSpecial['end_datetime'],
                                                                       'index' => $index]);
        }
        $content  = $this->getView()->renderPhpFile($mainFilePath, ['rows' => $rowContent]);
        $dummyDropdown = UiHtml::dropDownList('ProductSpecial[group_id_dummy][]', null, $items, ['class' => 'form-control dummy-special']);
        $content  .= $this->getView()->renderPhpFile($dummyFilePath, ['dropdown' => $dummyDropdown]);
        return $content;
    }
    
        /**
     * Override to register form submit script
     */
    protected function registerScripts()
    {
        $script     = "$('body').on('click', '#add-special-value-row',
                                    function(event, jqXHR, settings)
                                    {
                                        var rowCount         = $('#special-value-table tbody tr').length;
                                        var newTr            = $('.special-value-row-dummy').clone();
                                        $(newTr).removeClass('special-value-row-dummy').addClass('special-value-row');
                                        var newId            = 'special-value-row-' + (rowCount);
                                        $(newTr).attr('id', newId);
                                        $(newTr).find('.dummy-special').attr('name', 'ProductSpecial[group_id][]').removeClass('dummy-special');
                                        $(newTr).appendTo('#special-value-table tbody');
                                        $(newTr).show();
                                        $(newTr).find('.datefield').datetimepicker({autoclose:true, format:'yyyy-mm-dd hh:ii:ss'});
                                    }
                                )";
        $this->getView()->registerJs($script);
    }
    
    /**
     * Get file path.
     * @return string
     */
    protected function getFilePath()
    {
        return UsniAdaptor::getAlias('@products/views/_productSpecialRow') . '.php';
    }
    
    /**
     * Get main file path.
     * @return string
     */
    protected function getMainFilePath()
    {
        return UsniAdaptor::getAlias('@products/views/_productSpecialValues') . '.php';
    }
}