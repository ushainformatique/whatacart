<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\enhancement\grid;

use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
/**
 * EnhancementActionColumn class file.
 * 
 * @package common\modules\extension\grid
 */
class EnhancementActionColumn extends \common\modules\extension\grid\ExtensionActionColumn
{
    /**
     * @inheritdoc
     */
    protected function resolveChangeStatusUrl($model, $status)
    {
        return UsniAdaptor::createUrl("enhancement/default/change-status", array("id" => $model['id'], 'status' => $status));
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveSettingsUrl($model)
    {
        $data   = $model['data'];
        if(!empty($data))
        {
            $settings   = ArrayUtil::getValue($data, 'settings');
            if(!empty($settings))
            {
                $controllerPath = ArrayUtil::getValue($settings, 'controllerPath');
                return UsniAdaptor::createUrl($controllerPath);
            }
        }
        $category   = $model['category'];
        $code       = $model['code'];
        return UsniAdaptor::createUrl("$category/$code/settings/index");
    }
}