<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\grid;

use usni\UsniAdaptor;
/**
 * ModuleActionColumn class file.
 *
 * @package common\modules\extension\grid
 */
class ModuleActionColumn extends ExtensionActionColumn
{
    /**
     * @inheritdoc
     */
    protected function resolveChangeStatusUrl($model, $status)
    {
        return UsniAdaptor::createUrl("extension/module/change-status", ["id" => $model['id'], 'status' => $status]);
    }
}