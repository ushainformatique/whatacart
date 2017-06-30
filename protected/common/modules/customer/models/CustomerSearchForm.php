<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * CustomerSearchForm class file
 *
 * @package customer\models
 */
class CustomerSearchForm extends Model
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @var string 
     */
    public $username;
    
    /**
     * @var string 
     */
    public $timezone;
    
    /**
     * @var integer 
     */
    public $status;
    
    /**
     * @var string 
     */
    public $email;
    
    /**
     * @var string 
     */
    public $firstname;
    
    /**
     * @var string 
     */
    public $lastname;
    
    /**
     * @var string 
     */
    public $address1;

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
     * @return usni\library\dataproviders\ArrayRecordDataProvider
     */
    public function search()
    {
        $customerTable  = UsniAdaptor::tablePrefix() . 'customer';
        $personTable    = UsniAdaptor::tablePrefix() . 'person';
        $addressTable   = UsniAdaptor::tablePrefix() . 'address';
        $query          = new \yii\db\Query();
        $query->select("tc.*, person.email, person.firstname, person.lastname, address.address1")->from(["$customerTable tc"]);
        $query->innerJoin($personTable . ' person', 'tc.person_id = person.id');
        $query->leftJoin($addressTable . ' address', 'address.relatedmodel_id = person.id AND address.relatedmodel = :rm', [':rm' => 'Person']);
        $attributes = ['username', 'timezone', 'status', 'email', 'firstname', 'lastname', 'address1'];
        
        if($this->getLimit() != null)
        {
            $query->limit($this->getLimit());
        }
        
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => $attributes]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'tc.username', $this->username]);
        $query->andFilterWhere(['tc.status' => $this->status]);
        $query->andFilterWhere(['tc.timezone' => $this->timezone]);
        $query->andFilterWhere(['like', 'person.firstname', $this->firstname]);
        $query->andFilterWhere(['like', 'person.lastname', $this->lastname]);
        $query->andFilterWhere(['like', 'person.email', $this->email]);
        $query->andFilterWhere(['like', 'address.address1', $this->address1]);
        if($this->canAccessOwnedRecordsOnly('customer'))
        {
            $query->andFilterWhere(['tc.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
    
    /**
     * Get the limit for the search
     * @return null|int
     */
    protected function getLimit()
    {
        return null;
    }
}
