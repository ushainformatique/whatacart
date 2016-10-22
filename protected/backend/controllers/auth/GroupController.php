<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace backend\controllers\auth;

use customer\models\Customer;
use usni\library\modules\users\models\User;
use backend\views\auth\CustomerGroupGridView;
use customer\utils\CustomerUtil;
use usni\UsniAdaptor;
/**
 * Contains actions which extend the functionality related to group
 * 
 * @package backend\controllers\auth
 */
class GroupController extends \usni\library\modules\auth\controllers\GroupController
{
    /**
     * Get member model classes
     * @return array
     */
    protected function getMemberModelClasses()
    {
        return [User::className(), Customer::className()];
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveGridViewClassName($model)
    {
        return CustomerGroupGridView::className();
    }
    
    /**
     * @inheritdoc
     */
    protected function deleteModel($model)
    {
        $isAllowedToDelete = CustomerUtil::checkIfCustomerGroupAllowedToDelete($model);
        if(!$isAllowedToDelete)
        {
            $message = UsniAdaptor::t('customerflash', 'Delete failed as either this group is associated with tax rule or customer.');
            UsniAdaptor::app()->getSession()->setFlash('deleteFailed', $message);
            return false;
        }
        return parent::deleteModel($model);
    }
}