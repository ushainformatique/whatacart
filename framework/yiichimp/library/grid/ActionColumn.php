<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\grid;

use usni\library\utils\Html;
use usni\fontawesome\FA;
use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use usni\library\utils\StringUtil;

/**
 * ActionColumn class file.
 *
 * @package usni\library\grid
 */
class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * @var string 
     */
    public $modelClassName;
    
    /**
     * @var bool $allowCaching whether to allow caching the result of access check.
     */
    public $allowCaching = true;
    
    /**
     * @var string
     */
    public $permissionPrefix;


    /**
     * Initializes the default button rendering callbacks
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view']))
        {
            $this->buttons['view'] = array($this, 'renderViewActionLink');
        }
        if (!isset($this->buttons['update']))
        {
            $this->buttons['update'] = array($this, 'renderUpdateActionLink');
        }
        if (!isset($this->buttons['delete']))
        {
            $this->buttons['delete'] = array($this, 'renderDeleteActionLink');;
        }
    }

    /**
     * Renders view action link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    protected function renderViewActionLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'view'))
        {
            $icon       = FA::icon('eye');
            $options    = [
                            'title' => \Yii::t('yii', 'View'),
                            'data-pjax' => '0'
                          ];
            if($this->grid->isModalDetailView)
            {
                $url .= '&display=modal';
                $options = ArrayUtil::merge($options, ['data-toggle'  => 'modal',
                                                       'data-target'  => '#gridContentModal',
                                                       'data-url'     => $url]);
                $url = '#';
            }
            return Html::a($icon, $url, $options);
        }
        return null;
    }

    /**
     * Renders update action link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    protected function renderUpdateActionLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'update'))
        {
            $icon = FA::icon('pencil');
            return Html::a($icon, $url, [
                        'title' => \Yii::t('yii', 'Update'),
                        'data-pjax' => '0'
                    ]);
        }
        return null;
    }

    /**
     * Renders delete action link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    protected function renderDeleteActionLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'delete'))
        {
            $shortName = strtolower($this->getBaseModelClassName());
            $icon = FA::icon('trash-o');
            return Html::a($icon, $url, [
                        'title' => \Yii::t('yii', 'Delete'),
                        'id'    => 'delete-' . $shortName . '-' . $model['id'],
                        'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
        }
        return null;
    }

    /**
     * Resolve action button visibility
     * @param Model $model
     * @param string $buttonName
     * @param array $params name-value pairs that would be passed to the rules associated
     * with the roles and permissions assigned to the user.
     * @return boolean
     */
    public function checkAccess($model, $buttonName, $params = [])
    {
        $behaviors = $this->grid->getView()->context->behaviors();
        if(ArrayUtil::getValue($behaviors, 'access') === null)
        {
            return true;
        }
        $user   = UsniAdaptor::app()->user->getIdentity();
        if($user != null)
        {
            if(isset($model['created_by']) && ($user['id'] != $model['created_by']))
            {
                $buttonName = $buttonName . 'other';
            }
            if($this->permissionPrefix == null)
            {
                $this->permissionPrefix = strtolower($this->getBaseModelClassName());
            }
            if(UsniAdaptor::app()->user->can($this->permissionPrefix . '.' . $buttonName, $params, $this->allowCaching))
            {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Get model class name
     * @return type
     */
    protected function getBaseModelClassName()
    {
        return StringUtil::basename($this->modelClassName);
    }
}