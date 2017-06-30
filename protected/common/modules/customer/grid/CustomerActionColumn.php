<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\grid;

use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\utils\Html;
use usni\library\modules\users\models\User;
use usni\library\grid\ActionColumn;
/**
 * CustomerActionColumn class file.
 * 
 * @package customer\grid
 */
class CustomerActionColumn extends ActionColumn
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
            $url   = UsniAdaptor::createUrl("customer/default/change-password", ["id" => $model['id']]);
            return Html::a($icon, $url, [
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
        if($this->checkAccess($model, 'update'))
        {
            if($model['status'] == User::STATUS_ACTIVE)
            {
                $label = UsniAdaptor::t('users', 'Deactivate');
                $icon  = FA::icon('close');
                $url   = UsniAdaptor::createUrl("customer/default/change-status", array("id" => $model['id'], 'status' => User::STATUS_INACTIVE));
            }
            elseif($model['status'] == User::STATUS_INACTIVE || $model['status'] == User::STATUS_PENDING)
            {
                $label = UsniAdaptor::t('users', 'Activate');
                $icon  = FA::icon('check');
                $url   = UsniAdaptor::createUrl("customer/default/change-status", array("id" => $model['id'], 'status' => User::STATUS_ACTIVE));
            }
            return Html::a($icon, $url, [
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
        if($this->checkAccess($model, 'update'))
        {
            $shortName  = strtolower(UsniAdaptor::getObjectClassName($this->modelClassName));
            $icon       = FA::icon('pencil');
            return Html::a($icon, $url, [
                        'title' => \Yii::t('yii', 'Update'),
                        'data-pjax' => '0',
                        'id'        => 'update-' . $shortName . '-' . $model['id'],
                        'class'     => 'update-' . $shortName
                    ]);
        }
        return null;
    }
}