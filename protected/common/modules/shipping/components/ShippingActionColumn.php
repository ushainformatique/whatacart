<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\components;

use usni\UsniAdaptor;
/**
 * ShippingActionColumn class file.
 * @package common\modules\shipping\components
 */
class ShippingActionColumn extends \common\modules\extension\components\ExtensionActionColumn
{
    /**
     * @inheritdoc
     */
    protected function resolveChangeStatusUrl($model, $status)
    {
        return UsniAdaptor::createUrl("shipping/default/change-status", array("id" => $model->id, 'status' => $status));
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveSettingsUrl($model)
    {
        $category   = $model->category;
        $code       = $model->code;
        return UsniAdaptor::createUrl("$category/$code/settings/index");
    }
}