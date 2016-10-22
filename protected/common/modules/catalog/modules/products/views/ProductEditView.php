<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use usni\library\extensions\bootstrap\views\UiTabbedEditView;
use usni\library\components\UiHtml;
use usni\UsniAdaptor;
use usni\library\utils\ButtonsUtil;
use productCategories\models\ProductCategory;
use usni\library\components\UiActiveForm;
use usni\library\widgets\forms\NameWithAliasFormField;
use marqu3s\summernote\Summernote;
use usni\library\utils\StatusUtil;
use usni\library\utils\DAOUtil;
use taxes\models\ProductTaxClass;
use usni\library\utils\AdminUtil;
use common\modules\manufacturer\models\Manufacturer;
use dosamigos\selectize\SelectizeTextInput;
use products\utils\ProductUtil;
use products\views\AssignProductOptionsListView;
use usni\fontawesome\FA;
use products\views\AssignProductAttributeGridView;
use products\views\DiscountView;
use products\views\SpecialView;
use products\models\ProductSpecial;
use products\models\ProductDiscount;
use products\models\ProductOption;
use products\models\ProductImage;
use usni\library\utils\FlashUtil;
use products\models\ProductAttribute;
use dosamigos\datetimepicker\DateTimePickerAsset;
use dosamigos\datepicker\DatePicker;
use common\modules\localization\modules\lengthclass\models\LengthClass;
use common\modules\localization\modules\weightclass\models\WeightClass;
/**
 * Product Edit View.
 *
 * @package products\views
 */
class ProductEditView extends UiTabbedEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $category = new ProductCategory();
        if($this->model->getIsNewRecord())
        {
            $category->created_by = UsniAdaptor::app()->user->getUserModel()->id;
        }
        $elements = [
            'name'                => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => NameWithAliasFormField::className()],
            'alias'               => ['type' => 'text'],
            'model'               => ['type' => 'text'],
            'price'               => ['type' => 'text'],
            'description'         => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => Summernote::className()],
            'quantity'            => ['type' => 'text'],
            //Later Height and width would be picked up from store's image configuration.
            'thumbnail'           => ['type' => UiActiveForm::INPUT_RAW, 'value' => AdminUtil::renderThumbnail($this->model, 'image')],
            'image'               => ['type' => UiActiveForm::INPUT_FILE],
            'options'             => ['type' => UiActiveForm::INPUT_RAW, 'value' => $this->renderOptions()],  
            'attributes'          => ['type' => UiActiveForm::INPUT_RAW, 'value' => $this->renderAttributes()],  
            'sku'                 => ['type' => 'text'],
            'metakeywords'        => ['type' => 'textarea'],
            'metadescription'     => ['type' => 'textarea'],
            'status'              => UiHtml::getFormSelectFieldOptionsWithNoSearch(StatusUtil::getDropdown()),
            'tax_class_id'        => UiHtml::getFormSelectFieldOptionsWithNoSearch(DAOUtil::getDropdownDataBasedOnModel(ProductTaxClass::className())),
            'categories'          => UiHtml::getFormSelectFieldOptions($category->getMultiLevelSelectOptions('name', 0, '-', true, $this->shouldRenderOwnerCreatedModels()), ['closeOnSelect' => false], ['multiple' => 'multiple']),
            'tagNames'            => array('type' => UiActiveForm::INPUT_WIDGET, 'class' => SelectizeTextInput::className(), 
                                                     'loadUrl' => ['default/tags'], 
                                                     'clientOptions' => [
                                                                            'plugins' => ['remove_button'],
                                                                            'valueField' => 'name',
                                                                            'labelField' => 'name',
                                                                            'searchField' => ['name'],
                                                                            'create' => true,
                                                                        ], 
                                                     'options' => ['class' => 'form-control']),
            'minimum_quantity'    => ['type' => 'text'],
            'subtract_stock'      => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
            'requires_shipping'   => UiHtml::getFormSelectFieldOptions(AdminUtil::getYesNoOptions()),
            'manufacturer'        => UiHtml::getFormSelectFieldOptionsWithNoSearch(DAOUtil::getDropdownDataBasedOnModel(Manufacturer::className()), [], ['prompt' => UiHtml::getDefaultPrompt()]),
            'is_featured'         => ['type' => 'checkbox'],
            'relatedProducts'     => UiHtml::getFormSelectFieldOptions(ProductUtil::getRelatedProductOptions($this->model->id), ['closeOnSelect' => false], ['multiple' => 'multiple']),
            'stock_status'        => UiHtml::getFormSelectFieldOptionsWithNoSearch(ProductUtil::getOutOfStockSelectOptions()),
            'discounts'           => ['type' => UiActiveForm::INPUT_RAW, 'value' => $this->renderDiscounts()],
            'specials'            => ['type' => UiActiveForm::INPUT_RAW, 'value' => $this->renderSpecials()],
            'images'              => ['type' => UiActiveForm::INPUT_RAW, 'value' => $this->renderProductImages()],
            'location'            => ['type' => 'text'],
            'date_available'      => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => DatePicker::className(), 
                                              'template' => '{addon}{input}', 'clientOptions' => [
                                                                                                    'autoclose' => true,
                                                                                                    'format'    => 'yyyy-m-dd',
                                                                                                 ], 'options'   => ['class' => 'form-control']],
            'length'            => ['type' => 'text'],
            'width'             => ['type' => 'text'],
            'height'            => ['type' => 'text'],
            'weight'            => ['type' => 'text'],
            'length_class'      => UiHtml::getFormSelectFieldOptionsWithNoSearch(DAOUtil::getDropdownDataBasedOnModel(LengthClass::className())),
            'weight_class'      => UiHtml::getFormSelectFieldOptionsWithNoSearch(DAOUtil::getDropdownDataBasedOnModel(WeightClass::className()))
        ];

        $metadata = [
            'elements'      => $elements,
            'buttons'       => ButtonsUtil::getDefaultButtonsMetadata('catalog/products/default/manage')
        ];
        return $metadata;
    }

    /**
     * If form data multipart.
     * @return boolean
     */
    public function isMultiPartFormData()
    {
        return true;
    }

    /**
     * Get tabs.
     * @return array
     */
    protected function getTabs()
    {
        $tabs = [
                    'general'         => ['label' => UsniAdaptor::t('application', 'General'),
                                          'content' => $this->renderTabElements('general')],
                    'data'            => ['label' => UsniAdaptor::t('application', 'Data'),
                                          'content' => $this->renderTabElements('data')],
                    'specifications'  => ['label' => UsniAdaptor::t('products', 'Specifications'),
                                          'content' => $this->renderTabElements('specifications')],
                    'related'         => ['label' => UsniAdaptor::t('products', 'Related'),
                                          'content' => $this->renderTabElements('related')]
                    ];
        if($this->model->scenario == 'update')
        {
            $tabs['options']  = ['label' => ProductOption::getLabel(2),
                                'content' => $this->renderTabElements('options')];
            $tabs['attributes']  = ['label' => ProductAttribute::getLabel(2),
                                'content' => $this->renderTabElements('attributes')];
        }
        $tabs['discounts']  = ['label' => ProductDiscount::getLabel(2),
                               'content' => $this->renderTabElements('discounts')];
        $tabs['specials']   = ['label' => ProductSpecial::getLabel(2),
                               'content' => $this->renderTabElements('specials')];
        $tabs['images']     = ['label' => ProductImage::getLabel(2),
                               'content' => $this->renderTabElements('images')];
        return $tabs;
    }

    /**
     * Get tab elements map.
     * @return array
     */
    protected function getTabElementsMap()
    {
        return [
                'general'        => ['name', 'alias', 'description', 'metakeywords', 'metadescription', 'tagNames'],
                'data'           => ['status', 'tax_class_id', 'thumbnail', 'image', 'minimum_quantity', 'stock_status',
                                     'subtract_stock', 'requires_shipping', 'location', 'date_available', 'length', 'width', 'height', 
                                     'weight', 'length_class', 'weight_class', 'is_featured'],
                'specifications' => ['model', 'sku', 'price', 'quantity'],
                'related'        => ['manufacturer', 'categories',  'relatedProducts'],
                'options'        => ['options'],
                'attributes'     => ['attributes'],
                'discounts'      => ['discounts'],
                'specials'       => ['specials'],
                'images'         => ['images']
                ];
    }
    
    /**
     * Renders product option.
     * @return string
     */
    protected function renderOptions()
    {
        $editLabel  = FA::icon('pencil') . "\n" . UsniAdaptor::t('application', 'Edit');
        $editLink   = UiHtml::a($editLabel, UsniAdaptor::createUrl("catalog/products/option/product-options", ["product_id" => $this->model->id]), 
                                ['class' => 'btn btn-default', 'id' => 'options-edit-link']);
        $view       = new AssignProductOptionsListView(['product' => $this->model, 'shouldRenderActionColumn' => false]);
        return $editLink . $view->render();
    }
    
    /**
     * Renders product attributes.
     * @return string
     */
    protected function renderAttributes()
    {
        $layout     = "<div class='panel panel-content'><div class='panel-body'>{summary}\n{items}\n</div><div class='panel-footer'>{pager}</div></div>";
        $editLabel  = FA::icon('pencil') . "\n" . UsniAdaptor::t('application','Edit');
        $editLink   = UiHtml::a($editLabel, UsniAdaptor::createUrl("catalog/products/attribute/product-attributes", ["product_id" => $this->model->id]), 
                                ['class' => 'btn btn-default', 'id' => 'attributes-edit-link']);
        $view       = new AssignProductAttributeGridView(['productId' => $this->model->id,
                                                          'layout'    => $layout,
                                                          'rowsAreSelectable' => false]);
        return $editLink . $view->render();
    }
    
    /**
     * Renders discount.
     * @return string
     */
    protected function renderDiscounts()
    {
        $view       = new DiscountView(['product' => $this->model]);
        return $view->render();
    }
    
    /**
     * Renders special.
     * @return string
     */
    protected function renderSpecials()
    {
        $view       = new SpecialView(['product' => $this->model]);
        return $view->render();
    }
    
    /**
     * Renders product images.
     * @return string
     */
    protected function renderProductImages()
    {
        $view   = new ProductImagesEditView(['product' => $this->model]);
        return $view->render();
    }
    
    /**
     * @inheritdoc
     */
    protected function renderFlashMessages()
    {
        return FlashUtil::render('imageErrors', 'alert alert-danger');
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        parent::registerScripts();
        DateTimePickerAsset::register($this->getView());
        $script     = "$('body').find('.datefield').datetimepicker({autoclose:true, format:'yyyy-mm-dd hh:ii:ss'});";
        $this->getView()->registerJs($script);
        if($this->model->id != null)
        {
            $url = UsniAdaptor::createUrl('catalog/products/default/delete-image');
            AdminUtil::registerDeleteImageScripts($this->model->id, $url, get_class($this->model), $this->getView());
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $content = parent::renderContent();
        $dummyImageFilePath  = UsniAdaptor::getAlias('@common/modules/catalog/modules/products/views/_productImageDummy') . '.php';
        $dummyImage          = $this->getView()->renderPhpFile($dummyImageFilePath);
        return $content . $dummyImage;
    }
    
    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        return array(
            'is_featured' => array(
                    'options' => [],
                    'horizontalCheckboxTemplate' => "<div class=\"checkbox checkbox-admin\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}"
            )
        );
    }
}