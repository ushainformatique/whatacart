<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace backend\grid;

use yii\grid\DataColumn;
use usni\UsniAdaptor;
use products\behaviors\PriceBehavior;
/**
 * FormattedPriceColumn class file.
 * 
 * @package backend\grid
 */
class FormattedPriceColumn extends DataColumn
{
    /**
     * inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $priceBehavior = new PriceBehavior();
        return $priceBehavior->getFormattedPrice($model[$this->attribute], UsniAdaptor::app()->currencyManager->selectedCurrency);
    }
}