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
use products\models\ProductDiscount;
/**
 * Discount view for the product.
 * 
 * @package products\views
 */
class DiscountView extends UiView
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
        $productDiscounts           = ProductUtil::getProductDiscounts($this->product->id);
        $filePath                   = $this->getFilePath();
        $mainFilePath               = $this->getMainFilePath();
        $dummyFilePath              = UsniAdaptor::getAlias('@products/views/_productDiscountDummy') . '.php';
        $rowContent                 = null;
        $items                      = ArrayUtil::map($availableCustomerGroups, 'id', 'name');
        foreach($productDiscounts as $index => $productDiscount)
        {
            $dropdown   = UiHtml::dropDownList('ProductDiscount[group_id][]', $productDiscount['group_id'], $items, ['class' => 'form-control']);
            $rowContent .= $this->getView()->renderPhpFile($filePath, ['dropdown' => $dropdown,
                                                                       'quantity' => $productDiscount['quantity'],
                                                                       'priority' => $productDiscount['priority'],
                                                                       'price'    => $productDiscount['price'],
                                                                       'start_datetime' => $productDiscount['start_datetime'],
                                                                       'end_datetime'   => $productDiscount['end_datetime'],
                                                                       'index' => $index]);
        }
        $content  = $this->getView()->renderPhpFile($mainFilePath, ['rows' => $rowContent]);
        $dummyDropdown = UiHtml::dropDownList('ProductDiscount[group_id_dummy][]', null, $items, ['class' => 'form-control dummy-discount']);
        $content  .= $this->getView()->renderPhpFile($dummyFilePath, ['dropdown' => $dummyDropdown, 'model' => new ProductDiscount()]);
        return $content;
    }
    
    /**
     * Override to register form submit script
     */
    protected function registerScripts()
    {
        $script     = "$('body').on('click', '#add-discount-value-row',
                                    function(event, jqXHR, settings)
                                    {
                                        var rowCount         = $('#discount-value-table tbody tr').length;
                                        var newTr            = $('.discount-value-row-dummy').clone();
                                        $(newTr).removeClass('discount-value-row-dummy').addClass('discount-value-row');
                                        var newId            = 'discount-value-row-' + (rowCount);
                                        $(newTr).attr('id', newId);
                                        $(newTr).find('.dummy-discount').attr('name', 'ProductDiscount[group_id][]').removeClass('dummy-discount');
                                        $(newTr).appendTo('#discount-value-table tbody');
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
        return UsniAdaptor::getAlias('@products/views/_productDiscountRow') . '.php';
    }
    
    /**
     * Get main file path.
     * @return string
     */
    protected function getMainFilePath()
    {
       return UsniAdaptor::getAlias('@products/views/_productDiscountValues') . '.php'; 
    }
}