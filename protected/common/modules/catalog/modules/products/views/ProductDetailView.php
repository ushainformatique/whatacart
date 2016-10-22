<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use usni\library\views\UiDetailView;
use usni\UsniAdaptor;
use usni\library\views\UiTabbedView;
use products\views\ProductBrowseModelView;
use products\utils\ProductUtil;
/**
 * Product Detail View.
 *
 * @package products\views
 */
class ProductDetailView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $taxClassName   = null;
        $taxClassRecord = ProductUtil::getTaxClass($this->model->tax_class_id);
        if($taxClassRecord !== false)
        {
            $taxClassName = $taxClassRecord['name'];
        }
        return [
                    'name',
                    'alias',
                    [
                        'attribute'   => 'description',
                        'format'      => 'raw'
                    ],
                    [
                        'attribute' => 'tax_class_id',
                        'value'     => $taxClassName
                    ],
                    'metakeywords',
                    'metadescription',
                    [
                        'label' => UsniAdaptor::t('products', 'Product Tags'),
                        'value' => $this->getProductTags()
                    ]
               ];
    }

    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return $this->model->name;
    }
    
    /**
     * Gets delete button url.
     *
     * @return string
     */
    protected function getDeleteUrl()
    {
        return UsniAdaptor::createUrl('/catalog/' . $this->getModule() . '/' . $this->controller->id . '/delete', ['id' => $this->model->id]);
    }

    /**
     * Gets edit button url.
     *
     * @return string
     */
    protected function getEditUrl()
    {
        return UsniAdaptor::createUrl('/catalog/' . $this->getModule() . '/' . $this->controller->id . '/update', ['id' => $this->model->id]);
    }
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        //General tab content
        $content     = null;
        $infoContent = parent::renderContent();
        
        //Data tab content
        $productDataInstance    = new ProductDataView($this->getDetailViewConfiguration($this->model));
        $productdataView        = $productDataInstance->render();
       
        //Product specifications tab
        $productSpecificationInstance   = new ProductSpecificationView($this->getDetailViewConfiguration($this->model));
        $productSpecificationView       = $productSpecificationInstance->render();
        
        //Product related tab
        $productRelatedInstance     = new ProductRelatedView($this->getDetailViewConfiguration($this->model));
        $productRelatedView         = $productRelatedInstance->render();
        
        //Product options tab
        $productOptionsInstance     = new ProductOptionsView(['model' => $this->model]);
        $productOptionsView         = $productOptionsInstance->render();
        
        //Product attributes tab
        $productAttributesInstance      = new ProductAttributesView(['productId' => $this->model->id]);
        $productAttributeView           = $productAttributesInstance->render();
        
        //Product discounts tab
        $productDiscountInstance      = new ProductDiscountView(['product' => $this->model]);
        $productDiscountView          = $productDiscountInstance->render();
        
        //Product specials tab
        $productSpecialInstance      = new ProductSpecialsView(['product' => $this->model]);
        $productSpecialView          = $productSpecialInstance->render();
        
        //Product images tab
        $productImageInstance      = new ProductImagesView(['product' => $this->model]);
        $productImageView          = $productImageInstance->render();
        
        $tabs        = [
                            'productInfo'    => ['label'   => UsniAdaptor::t('application', 'General'),
                                                 'content' => $infoContent,
                                                 'active'  => true],
                            'dataInfo'      => ['label'   => UsniAdaptor::t('application', 'Data'),
                                                'content' => $productdataView],
                            'specificationInfo' => ['label'   => UsniAdaptor::t('products', 'Specifications'),
                                                    'content' => $productSpecificationView],
                            'relatedInfo'   => ['label'   => UsniAdaptor::t('products', 'Related'),
                                                'content' => $productRelatedView],
                            'optionInfo'    => ['label'   => UsniAdaptor::t('products', 'Options'),
                                                'content' => $productOptionsView],
                            'attributeInfo' => ['label'   => UsniAdaptor::t('products', 'Attributes'),
                                                'content' => $productAttributeView],
                            'discountInfo'  => ['label'   => UsniAdaptor::t('products', 'Discounts'),
                                                'content' => $productDiscountView],
                            'specialInfo'   => ['label'   => UsniAdaptor::t('products', 'Specials'),
                                                'content' => $productSpecialView],
                            'imageInfo'     => ['label'   => UsniAdaptor::t('products', 'Images'),
                                                'content' => $productImageView],
                                           ];
        $tabbedView  = new UiTabbedView($tabs);
        $content    .= $tabbedView->render();
        return $content;
    }
    
    /**
     * Get configuration for rendering grid view.
     * @param Model $model
     * @return array
     */
    protected function getDetailViewConfiguration($model)
    {
        return [
                    'model'       => $model,
                    'controller'  => $this->controller
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected static function resolveBrowseModelViewClassName()
    {
        return ProductBrowseModelView::className();
    }
    
    /**
     * Get product tags.
     * @return string
     */
    protected function getProductTags()
    {
        $tags       = ProductUtil::getProductTags($this->model->id);
        $tagNames   = [];
        foreach ($tags as $tag)
        {
            $tagNames[] = $tag['name'];
        }
        return implode(', ', $tagNames);
    }
}
?>