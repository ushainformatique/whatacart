<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\grid;

use yii\grid\DataColumn;
use products\behaviors\PriceBehavior;
use usni\UsniAdaptor;
/**
 * FormattedPriceColumn class file.
 * 
 * @package common\modules\order\grid
 */
class FormattedPriceColumn extends DataColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $price          = $model['total_including_tax'] + $model['shipping_fee'];
        $price          = number_format($price, 2, ".", "");
        $priceBehavior  = new PriceBehavior();
        return $priceBehavior->getFormattedPrice($price, UsniAdaptor::app()->currencyManager->selectedCurrency);
    }
}