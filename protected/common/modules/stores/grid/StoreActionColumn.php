<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\grid;

use usni\library\grid\ActionColumn;
use common\modules\stores\models\Store;
use usni\library\utils\Html;
use usni\UsniAdaptor;
use usni\fontawesome\FA;

/**
 * StoreActionColumn class file.
 * 
 * @package common\modules\stores\grid
 */
class StoreActionColumn extends ActionColumn
{
    /**
     * @inheritdoc
     */
    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();
        if (!isset($this->buttons['activate']))
        {
            $this->buttons['activate'] = array($this, 'renderActivateDeactivateUrlLink');
        }
        if(!isset($this->buttons['default']))
        {
            $this->buttons['default'] = array($this, 'renderSetDefaultStoreLink');
        }
    }
    
    /**
     * Renders activate/deactivate url link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderActivateDeactivateUrlLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'manage'))
        {
            if($model['is_default'] || $model['id'] === Store::DEFAULT_STORE_ID)
            {
                return null;
            }
            $label = UsniAdaptor::t('stores', 'Activate/Deactivate');
            if($model['status'] == Store::STATUS_ACTIVE)
            {
                $icon   = FA::icon('thumbs-up');
                $url    = UsniAdaptor::createUrl("/stores/default/change-status", ["id" => $model['id'], "status" => Store::STATUS_INACTIVE]);
                return Html::a($icon, $url, ['title' => $label, 'data-pjax' => 0]);
            }
            else
            {
                $icon   = FA::icon('thumbs-down');
                $url    = UsniAdaptor::createUrl("/stores/default/change-status", ["id" => $model['id'], "status" => Store::STATUS_ACTIVE]);
                return Html::a($icon, $url, ['title' => $label, 'data-pjax' => 0]);
            }
        }
    }
    
    /**
     * Renders url to set default store.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderSetDefaultStoreLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'manage'))
        {
            if(!$model['is_default'] && $model['status'] == Store::STATUS_ACTIVE)
            {
                $icon   = FA::icon('check-square-o');
                $url    = UsniAdaptor::createUrl("stores/default/set-default-store", ["id" => $model['id']]);
                return Html::a($icon, $url, ['data-pjax' => 0, 'title' => UsniAdaptor::t('stores', 'Set as default')]);
            }
            else
            {
                return null;
            }
        }
    }
    
    /**
     * @inheritdoc
     * Default store can not delete.
     */
    protected function renderDeleteActionLink($url, $model, $key)
    {
        if($model['is_default'] || $model['id'] == Store::DEFAULT_STORE_ID)
        {
            return null;
        }
        
        if($this->checkAccess($model, 'delete'))
        {
            $icon = FA::icon('trash-o');
            return Html::a($icon, $url, [
                        'title' => \Yii::t('yii', 'Delete'),
                        'id'    => 'delete-store-' . $model['id'],
                        'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
        }
        return null;
    }
}
