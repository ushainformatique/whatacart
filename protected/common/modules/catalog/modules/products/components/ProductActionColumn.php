<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\components;

use usni\library\extensions\bootstrap\widgets\UiActionColumn;
use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\components\UiHtml;

/**
 * ProductActionColumn class file.
 * @package products\components
 */
class ProductActionColumn extends UiActionColumn
{
    /**
     * Initializes the default button rendering callbacks
     */
    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();
        if (!isset($this->buttons['attributes']))
        {
            $this->buttons['attributes'] = array($this, 'renderAttributesLink');
        }
        if (!isset($this->buttons['options']))
        {
            $this->buttons['options'] = array($this, 'renderOptionsLink');
        }
    }

    /**
     * Render attributes link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderAttributesLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'update'))
        {
            $label = UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('products', 'Attributes');
            $icon  = FA::icon('list');
            $url   = UsniAdaptor::createUrl("catalog/products/attribute/product-attributes", ["product_id" => $model->id]);
            return UiHtml::a($icon, $url, [
                                                'title' => $label,
                                                'data-pjax' => '0'
                                          ]);
        }
        return null;
    }
    
    /**
     * Render options link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderOptionsLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'update'))
        {
            $label = UsniAdaptor::t('application', 'Manage') . ' ' . UsniAdaptor::t('products', 'Options');
            $icon  = FA::icon('list-ul');
            $url   = UsniAdaptor::createUrl("catalog/products/option/product-options", ["product_id" => $model->id]);
            return UiHtml::a($icon, $url, [
                                                'title' => $label,
                                                'data-pjax' => '0'
                                          ]);
        }
        return null;
    }
}
?>