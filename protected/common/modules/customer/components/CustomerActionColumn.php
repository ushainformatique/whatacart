<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\components;

use usni\library\extensions\bootstrap\widgets\UiActionColumn;
use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\components\UiHtml;
use usni\library\modules\users\models\User;
use usni\library\modules\auth\managers\AuthManager;
/**
 * CustomerActionColumn class file.
 * @package customer\components
 */
class CustomerActionColumn extends UiActionColumn
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
        $user   = UsniAdaptor::app()->user->getUserModel();
        if(AuthManager::checkAccess($user, 'customer.change-password'))
        {
            $label = UsniAdaptor::t('users', 'Change Password');
            $icon  = FA::icon('lock');
            $url   = UsniAdaptor::createUrl("customer/default/change-password", ["id" => $model->id]);
            return UiHtml::a($icon, $url, [
                                                'title' => $label,
                                                'data-pjax' => '0'
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
        $user   = UsniAdaptor::app()->user->getUserModel();
        if(AuthManager::checkAccess($user, 'customer.update'))
        {
            if($model->status == User::STATUS_ACTIVE)
            {
                $label = UsniAdaptor::t('users', 'Deactivate');
                $icon  = FA::icon('close');
                $url   = UsniAdaptor::createUrl("customer/default/change-status", array("id" => $model->id, 'status' => User::STATUS_INACTIVE));
            }
            elseif($model->status == User::STATUS_INACTIVE || $model->status == User::STATUS_PENDING)
            {
                $label = UsniAdaptor::t('users', 'Activate');
                $icon  = FA::icon('check');
                $url   = UsniAdaptor::createUrl("customer/default/change-status", array("id" => $model->id, 'status' => User::STATUS_ACTIVE));
            }
            return UiHtml::a($icon, $url, [
                                                'title' => $label
                                          ]);
        }
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderUpdateActionLink($url, $model, $key)
    {
        $user   = UsniAdaptor::app()->user->getUserModel();
        if(AuthManager::checkAccess($user, 'customer.update'))
        {
            $shortName = strtolower(UsniAdaptor::getObjectClassName($this->grid->owner->model));
            $icon = FA::icon('pencil');
            return UiHtml::a($icon, $url, [
                        'title' => \Yii::t('yii', 'Update'),
                        'data-pjax' => '0',
                        'id'        => 'update-' . $shortName . '-' . $model['id'],
                        'class'     => 'update-' . $shortName
                    ]);
        }
        return null;
    }
}
?>