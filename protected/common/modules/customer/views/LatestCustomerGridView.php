<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views;

use usni\library\components\UiGridView;
use usni\UsniAdaptor;
use usni\library\modules\auth\managers\AuthManager;
use yii\data\ActiveDataProvider;
use customer\models\Customer;
use usni\library\modules\users\models\User;
use customer\widgets\CustomerNameDataColumn;
/**
 * LatestCustomerGridView class file.
 * @package customer\views
 */
class LatestCustomerGridView extends UiGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                        [
                            'attribute'     => 'username',
                            'class'         => CustomerNameDataColumn::className(),
                            'enableSorting' => false
                        ],
                        [
                            'label'     => UsniAdaptor::t('users', 'Email'),
                            'value'     => 'person.email'
                        ],
                        [
                            'attribute' => 'status',
                            'class'     => 'usni\library\modules\users\widgets\UserStatusDataColumn',
                            'filter'    => User::getStatusDropdown()
                        ],
                   ];
        return $columns;
    }

    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return UsniAdaptor::t('customer', 'Latest Customers');
    }
    
    /**
     * @inheritdoc
     */
    protected function getDataProvider()
    {
        $user   = UsniAdaptor::app()->user->getUserModel();
        $query  = Customer::find()->orderBy('id DESC');
        if(!(AuthManager::isUserInAdministrativeGroup($user)
                    && AuthManager::isSuperUser($user)) && !AuthManager::checkAccess($user, 'user.viewother'))
        {
            $query->andFilterWhere(['created_by' => $user->id]);
        }
        $query->limit(5);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $dataProvider->setPagination(false);
        return $dataProvider;
    }

    /**
     * @inheritdoc
     */
    protected function renderToolbar()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderCheckboxColumn()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected function getLayout()
    {
        return "<div class='panel panel-default'><div class='panel-heading'>{caption}</div>\n{items}</div>";
    }
}
?>