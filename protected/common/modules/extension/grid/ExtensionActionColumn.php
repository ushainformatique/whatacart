<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\grid;

use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\utils\Html;
use common\modules\extension\models\Extension;
use usni\library\grid\ActionColumn;
/**
 * ExtensionActionColumn class file.
 *
 * @package common\modules\extension\grid
 */
class ExtensionActionColumn extends ActionColumn
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
            return Html::a($icon, $url, [
                                                'title' => $label,
                                                'data-pjax' => 0
                                          ]);
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
            if($model['status'] == Extension::STATUS_ACTIVE)
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
            return Html::a($icon, $url, [
                                                'title' => $label,
                                                'data-pjax' => '0',
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
        return UsniAdaptor::createUrl("extension/default/change-status", array("id" => $model['id'], 'status' => $status));
    }
    
    /**
     * Resolve settings url
     * @param Model $model
     * @return string
     */
    protected function resolveSettingsUrl($model)
    {
        $category   = $model['category'];
        $code       = $model['code'];
        return UsniAdaptor::createUrl("$category/$code/settings/index");
    }
}