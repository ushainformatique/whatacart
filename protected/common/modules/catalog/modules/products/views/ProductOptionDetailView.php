<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use common\modules\catalog\views\BaseDetailView;
use usni\UsniAdaptor;
use products\utils\ProductUtil;
/**
 * ProductOptionDetailView class file
 * @package products\views
 */
class ProductOptionDetailView extends BaseDetailView
{

    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                 'name',
                 'display_name',
                 'type',
                 [
                     'label'  => UsniAdaptor::t('products', 'Option Values'),
                     'value'  => $this->getProductOptionValues()
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
     * Get product option values.
     * @return string
     */
    protected function getProductOptionValues()
    {
        $optionValues = ProductUtil::getProductOptionValues($this->model->id);
        if(!empty($optionValues))
        {
            $values       = [];
            foreach ($optionValues as $optionValue)
            {
                $values[] = $optionValue['value'];
            }
            return implode(', ', $values);
        }
        return UsniAdaptor::t('application', '(not set)');
    }
}
?>