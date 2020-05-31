<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\grid;

use usni\UsniAdaptor;
use usni\library\utils\Html;
use common\modules\extension\models\Extension;
use usni\fontawesome\FA;
/**
 * ShippingActionColumn class file.
 * 
 * @package common\modules\shipping\grid
 */
class ShippingActionColumn extends \common\modules\extension\grid\ExtensionActionColumn
{
    /**
     * @inheritdoc
     */
    protected function resolveChangeStatusUrl($model, $status)
    {
        $category   = $model['category'];
        $code       = $model['code'];
        return UsniAdaptor::createUrl("$category/$code/default/change-status", ["id" => $model['id'], 'status' => $status]);
    }
    
    /**
     * @inheritdoc
     */
    public function renderChangeStatusLink($url, $model, $key)
    {
        $label  = null;
        $icon   = null;
        $url    = null;
        if($this->checkAccess($model, 'update'))
        {
            if($model['status'] == Extension::STATUS_ACTIVE && $model['allowToDeactivate'])
            {
                $label = UsniAdaptor::t('users', 'Deactivate');
                $icon  = FA::icon('close');
                $url   = $this->resolveChangeStatusUrl($model, Extension::STATUS_INACTIVE);
            }
            elseif($model['status'] == Extension::STATUS_INACTIVE)
            {
                $label = UsniAdaptor::t('users', 'Activate');
                $icon  = FA::icon('check');
                $url   = $this->resolveChangeStatusUrl($model, Extension::STATUS_ACTIVE);
            }
            if($label != null && $icon != null && $url != null)
            {
                return Html::a($icon, $url, [
                                                'title' => $label,
                                                'data-pjax' => '0',
                                          ]);
            }
        }
        return null;
    }
}