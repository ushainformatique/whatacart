<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\components;

use usni\library\extensions\bootstrap\widgets\UiDataColumn;
use usni\library\components\UiHtml;
use usni\UsniAdaptor;
/**
 * ProductNameDataColumn class file.
 *
 * @package common\modules\catalog\components
 */
class ProductNameDataColumn extends UiDataColumn
{
    /**
     * @inheritdoc
     */
    public function renderDataCellContent($model, $key, $index)
    {
        return UiHtml::a($model['name'], UsniAdaptor::createUrl("/catalog/products/default/view", ["id" => $model['id']]), ['data-pjax' => '0']);
    }
}