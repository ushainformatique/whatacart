<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\components;

use usni\library\extensions\bootstrap\widgets\UiActionColumn;
use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\components\UiHtml;
use common\modules\extension\models\Extension;
/**
 * ExtensionActionColumn class file.
 *
 * @package common\modules\extension\components
 */
class ExtensionActionColumn extends UiActionColumn
{
    /**
     * Initializes the default button rendering callbacks
     */
    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();
        if (!isset($this->buttons['changestatus']))
        {
            $this->buttons['changestatus'] = array($this, 'renderChangeStatusLink');
        }
        if (!isset($this->buttons['settings']))
        {
            $this->buttons['settings'] = array($this, 'renderSettingsLink');
        }
    }
    
    /**
     * Renders settings link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderSettingsLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'manage'))
        {
            $label = UsniAdaptor::t('application', 'Settings');
            $icon  = FA::icon('cog'). "\n";
            $url   = $this->resolveSettingsUrl($model);
            return UiHtml::a($icon, $url, [
                                                'title' => $label,
                                                'data-pjax' => 0
                                          ]);
        }
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderViewActionLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'view'))
        {
            $shortName  = strtolower(UsniAdaptor::getObjectClassName($this->grid->owner->model));
            $icon       = FA::icon('eye');
            $options    = [
                            'title' => \Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'id'        => 'view-' . $shortName . '-' . $model['id'],
                            'class'     => 'view-' . $shortName
                          ];
            return UiHtml::a($icon, $url, $options);
        }
        return null;
    }
    
    /**
     * Renders change status link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderChangeStatusLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'update'))
        {
            if($model->status == Extension::STATUS_ACTIVE)
            {
                $label = UsniAdaptor::t('users', 'Deactivate');
                $icon  = FA::icon('close');
                $url   = $this->resolveChangeStatusUrl($model, Extension::STATUS_INACTIVE);
            }
            elseif($model->status == Extension::STATUS_INACTIVE)
            {
                $label = UsniAdaptor::t('users', 'Activate');
                $icon  = FA::icon('check');
                $url   = $this->resolveChangeStatusUrl($model, Extension::STATUS_ACTIVE);
            }
            return UiHtml::a($icon, $url, [
                                                'title' => $label
                                          ]);
        }
        return null;
    }
    
    /**
     * Resolve change status url
     * @param Model $model
     * @param int $status
     * @return string
     */
    protected function resolveChangeStatusUrl($model, $status)
    {
        return UsniAdaptor::createUrl("extension/default/change-status", array("id" => $model->id, 'status' => $status));
    }
    
    /**
     * Resolve settings url
     * @param Model $model
     * @return string
     */
    protected function resolveSettingsUrl($model)
    {
        return UsniAdaptor::createUrl("extension/default/settings", array("id" => $model->id));
    }
}