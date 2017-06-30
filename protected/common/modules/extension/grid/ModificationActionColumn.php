<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\grid;

use usni\UsniAdaptor;
/**
 * ModificationActionColumn class file.
 *
 * @package common\modules\extension\grid
 */
class ModificationActionColumn extends ExtensionActionColumn
{
    /**
     * @inheritdoc
     */
    protected function resolveChangeStatusUrl($model, $status)
    {
        return UsniAdaptor::createUrl("extension/modification/change-status", ["id" => $model['id'], 'status' => $status]);
    }
}