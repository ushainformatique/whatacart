<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\behaviors;

use common\modules\order\dto\InvoiceDetailViewDTO;
/**
 * Implements extended functionality related to invoice
 *
 * @package common\modules\order\behaviors
 */
class InvoiceManagerBehavior extends \yii\base\Behavior
{
    /**
     * Populate extra attributes in model
     * @param InvoiceDetailViewDTO $detailViewDTO
     * @param array $order
     */
    public function populateExtraAttributesInModel($detailViewDTO, $order)
    {
        
    }
}