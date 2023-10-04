<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\grid;

use usni\library\grid\ActionColumn;
use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\utils\Html;
/**
 * AuthActionColumn class file.
 * 
 * @package usni\library\modules\auth\grid
 */
class AuthActionColumn extends ActionColumn
{
    /**
     * @inheritdoc
     */
    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();
        if (!isset($this->buttons['managepermissions']))
        {
            $this->buttons['managepermissions'] = [$this, 'renderPermissionLink'];
        }
    }

    /**
     * Renders manage permission link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderPermissionLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'managepermissions'))
        {
            $label = UsniAdaptor::t('auth', 'Manage Permissions');
            $icon  = FA::icon('lock');
            $url   = UsniAdaptor::createUrl("auth/permission/manage", array("id" => $model['id']));
            return Html::a($icon, $url, [
                                                'title' => $label,
                                                'data-pjax' => '0',
                                                'id'    => 'permission-group-' . $model['id']
                                          ]);
        }
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function checkAccess($model, $buttonName, $params = [])
    {
        if($buttonName === 'managepermissions')
        {
            $permission = 'auth.' . $buttonName;
            if(UsniAdaptor::app()->user->can($permission, $params, $this->allowCaching))
            {
                return true;
            }
            return false;
        }
        else
        {
            return parent::checkAccess($model, $buttonName, $params);
        }
    }
}