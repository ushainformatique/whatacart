<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\components;

use usni\library\modules\auth\components\AuthActionColumn;
use customer\utils\CustomerUtil;
use usni\fontawesome\FA;
use usni\library\components\UiHtml;
use usni\UsniAdaptor;
use usni\library\modules\auth\models\Group;
/**
 * CustomerAuthActionColumn class file.
 * 
 * @package backend\components
 */
class CustomerAuthActionColumn extends AuthActionColumn
{
    /**
     * @inheritdoc
     */
    protected function renderDeleteActionLink($url, $model, $key)
    {
        $isAllowed              = CustomerUtil::checkIfCustomerGroupAllowedToDelete($model);
        //Parent customer group can not be delete.
        $groupName              = CustomerUtil::getDefaultGroupTitle();
        $parentCustomerGroup    = Group::findByName($groupName);
		$groupName              = CustomerUtil::getDefaultGroupTitle();
        if($parentCustomerGroup['id'] == $model['id'])
        {
            return null;
        }
        if($isAllowed)
        {
            if($this->checkAccess($model, 'delete'))
            {
                $shortName = strtolower(UsniAdaptor::getObjectClassName($this->grid->owner->model));
                $icon = FA::icon('trash-o');
                return UiHtml::a($icon, $url, [
                            'title' => \Yii::t('yii', 'Delete'),
                            'id'    => 'delete-' . $shortName . '-' . $model['id'],
                            'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
            }
            return null;
        }
        return null;
    }
}