<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\grid;

use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\utils\Html;
use usni\library\modules\users\models\User;
use usni\library\grid\ActionColumn;
/**
 * UserActionColumn class file.
 * 
 * @package usni\library\modules\users\grid
 */
class UserActionColumn extends ActionColumn
{
    /**
     * Initializes the default button rendering callbacks
     */
    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();
        if (!isset($this->buttons['changepassword']))
        {
            $this->buttons['changepassword'] = array($this, 'renderChangePasswordLink');
        }
        if (!isset($this->buttons['changestatus']))
        {
            $this->buttons['changestatus'] = array($this, 'renderChangeStatusLink');
        }
    }

    /**
     * Renders change password link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderChangePasswordLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'change-password'))
        {
            $label = UsniAdaptor::t('users', 'Change Password');
            $icon  = FA::icon('lock');
            $url   = $this->getChangePasswordUrl($model['id']);
            return Html::a($icon, $url, [
                                                'title'     => $label,
                                                'data-pjax' => '0'
                                          ]);
        }
        return null;
    }
    
    /**
     * Get change password url. 
     * @param integer $id
     * @return string
     */
    protected function getChangePasswordUrl($id)
    {
        return UsniAdaptor::createUrl("users/default/change-password", ["id" => $id]);
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
            if($model['status'] == User::STATUS_ACTIVE)
            {
                $label = UsniAdaptor::t('users', 'Deactivate');
                $icon  = FA::icon('close');
                $url   = UsniAdaptor::createUrl("users/default/change-status", array("id" => $model['id'], 'status' => User::STATUS_INACTIVE));
            }
            elseif($model['status'] == User::STATUS_INACTIVE || $model['status'] == User::STATUS_PENDING)
            {
                $label = UsniAdaptor::t('users', 'Activate');
                $icon  = FA::icon('check');
                $url   = UsniAdaptor::createUrl("users/default/change-status", array("id" => $model['id'], 'status' => User::STATUS_ACTIVE));
            }
            return Html::a($icon, $url, [
                                                'title' => $label
                                          ]);
        }
        return null;
    }
}