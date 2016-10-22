<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use usni\library\modules\auth\managers\AuthManager;
use usni\UsniAdaptor;
use usni\library\components\Sort;
/**
 * CustomerSearchForm class file
 *
 * @package customer\models
 */
class CustomerSearchForm extends Model
{
    //Customer fields
    public $username;
    public $timezone;
    public $status;
    //Person fields
    public $email;
    public $firstname;
    public $lastname;
    //Address fields
    public $address1;
    public $city;
    public $country;
    public $postal_code;
    public $address2;
    public $state;

    /**
     * Validation rules for the model.
     * @return array Validation rules for model attributes.
     */
    public function rules()
    {
        return [
                    [['username', 'timezone', 'status', 'email', 'firstname', 'lastname', 'address1'], 'safe'],
               ];
    }

    /**
     * Sets the scenarios for the user edit form.
     * @return string
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Search based on get params.
     *
     * @return yii\data\ActiveDataProvider
     */
    public function search()
    {
        $query              = Customer::find();
        $personTable        = UsniAdaptor::tablePrefix() . 'person';
        $addressTable       = UsniAdaptor::tablePrefix() . 'address';
        $query->select('tu.*')->from(Customer::tableName() . ' tu');
        $query->innerJoin($personTable . ' person', 'tu.person_id = person.id');
        $query->leftJoin($addressTable . ' address', 'address.relatedmodel_id = person.id AND address.relatedmodel = :rm', [':rm' => 'Person']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $sort = new Sort(['attributes' => ['username', 'email', 'status', 'person.email', 'person.firstname', 'person.lastname', 'timezone', 
                                           'address.address1']]);
        $dataProvider->setSort($sort);
        // load the seach form data and validate
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $user               = UsniAdaptor::app()->user->getUserModel();
        $query->andFilterWhere(['like', 'tu.username', $this->username]);
        $query->andFilterWhere(['tu.status' => $this->status]);
        $query->andFilterWhere(['tu.timezone' => $this->timezone]);
        $query->andFilterWhere(['like', 'person.firstname', $this->firstname]);
        $query->andFilterWhere(['like', 'person.lastname', $this->lastname]);
        $query->andFilterWhere(['like', 'person.email', $this->email]);
        //Address
        $query->andFilterWhere(['like', 'address.address1', $this->address1]);
        if(!empty($this->groups))
        {
            $inputGroups    = $this->groups;
            $criteria->join = 'INNER JOIN tbl_group_members tgm ON tgm.member_id = t.id';
            $criteria->compare('group_id', $inputGroups);
        }
        if(!AuthManager::checkAccess($user, 'customer.updateother')
            && !AuthManager::checkAccess($user, 'customer.viewother')
               && !AuthManager::checkAccess($user, 'customer.deleteother')
                && !AuthManager::checkAccess($user, 'customer.changeotherspassword'))
        {
            $query->andFilterWhere(['tu.created_by' => $user->id]);
        }
        return $dataProvider;
    }

}
