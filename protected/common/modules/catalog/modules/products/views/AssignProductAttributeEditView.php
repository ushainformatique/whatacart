<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
use usni\library\components\UiHtml;
use usni\UsniAdaptor;
use usni\library\utils\DAOUtil;
use usni\library\components\UiActiveForm;
use products\models\ProductAttribute;
use products\views\AssignProductAttributeGridView;
/**
 * AssignProductAttributeEditView class file
 * 
 * @package products\views
 */
class AssignProductAttributeEditView extends UiBootstrapEditView
{
    /**
     * Product model.
     * @var Product 
     */
    public $product;
    
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $data = DAOUtil::getDropdownDataBasedOnModel(ProductAttribute::className());
        $elements = [
            'attribute_id'     => UiHtml::getFormSelectFieldOptions($data, [], ['placeholder' => UiHtml::getDefaultPrompt()]),
            'attribute_value'  => ['type' => 'text'],
            'product_id'       => ['type' => UiActiveForm::INPUT_HIDDEN]
        ];
        $metadata =  [
                        'elements' => $elements,
                        'buttons'  => ButtonsUtil::getDefaultButtonsMetadata('catalog/products/default/manage')
                     ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $content    = parent::renderContent();
        $gridView   = new AssignProductAttributeGridView(['productId' => $this->model->product_id]);
        return $content . $gridView->render();
    }
    
    /**
     * @inheritdoc
     */
    public function renderTitle()
    {
        return UsniAdaptor::t('products', 'Assign Product Attributes');
    }
    
    /**
     * Override to register form submit script
     */
    protected function registerScripts()
    {
        $formId             = static::getFormId();
        $pjaxContainerId    = strtolower(UsniAdaptor::getObjectClassName(AssignProductAttributeGridView::className())) . '-pjax';;
        $url                = UsniAdaptor::createUrl('/catalog/products/attribute/assign');
        $productId          = $this->model->product_id;
        $script             = "$('#{$formId}').on('beforeSubmit',
                                     function(event, jqXHR, settings)
                                     {
                                        var form = $(this);
                                        if(form.find('.has-error').length) {
                                                return false;
                                        }
                                        $.ajax({
                                                    url: '{$url}',
                                                    type: 'post',
                                                    data: 'productId = {$productId}',
                                                    beforeSend: function()
                                                                {
                                                                    $.fn.attachLoader('#{$formId}');
                                                                },
                                                    data: form.serialize()
                                                })
                                        .done(function(data, statusText, xhr){
                                                                //Timeout is critical here else pjax expires and
                                                                //and page got refreshed
                                                                $.pjax.reload({container:'#{$pjaxContainerId}', 'timeout':2000});
                                                                $.fn.removeLoader('#{$formId}');
                                                                $('#productattributemapping-attribute_id').select2('val', null);
                                                                $('#productattributemapping-attribute_value').val(null);
                                                              });

                                                return false;
                                     })";
        $this->getView()->registerJs($script);
    }
}
?>