<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\views;

use usni\library\views\UiDetailView;
use usni\UsniAdaptor;
use taxes\utils\TaxUtil;
/**
 * TaxRuleDetailView class file
 *
 * @package taxes\views
 */
class TaxRuleDetailView extends UiDetailView
{

    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                    'name',
                    ['attribute' => 'based_on', 'value' => TaxUtil::getBasedOnDisplayValue($this->model->based_on)],
                    [
                        'label'     => UsniAdaptor::t('customer', 'Customer Group'),
                        'attribute' => 'customerGroups',
                        'value'     => $this->model->getCustomerGroup($this->model)
                    ],
                    [
                        'label'     => UsniAdaptor::t('tax', 'Product Tax Class'),
                        'attribute' => 'productTaxClass',
                        'value'     => $this->model->renderProductTaxClass()
                    ],
                    [
                        'label'     => UsniAdaptor::t('tax', 'Tax Rates'),
                        'attribute' => 'taxRates',
                        'value'     => $this->model->renderTaxRates()
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
        return UsniAdaptor::createUrl('localization/' . $this->getModule() . '/' . $this->controller->id . '/delete', ['id' => $this->model->id]);
    }

    /**
     * Gets edit button url.
     *
     * @return string
     */
    protected function getEditUrl()
    {
        return UsniAdaptor::createUrl('localization/' . $this->getModule() . '/' . $this->controller->id . '/update', ['id' => $this->model->id]);
    }
}
?>