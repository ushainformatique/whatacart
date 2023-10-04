<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
use usni\library\modules\users\models\User;
/**
 * UserSearchForm class file
 *
 * @package usni\library\modules\users\models
 */
class UserSearchForm extends Model
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['username', 'timezone', 'status', 'email', 'firstname', 'lastname', 'address1', ], 'safe'],
               ];
    }

    /**
     * @inheritdoc
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
        $userTable      = UsniAdaptor::tablePrefix() . 'user';
        $personTable    = UsniAdaptor::tablePrefix() . 'person';
        $addressTable   = UsniAdaptor::tablePrefix() . 'address';
        $query          = new \yii\db\Query();
        $query->select("tu.*, person.email, person.firstname, person.lastname, address.address1")->from(["$userTable tu"]);
        $query->innerJoin($personTable . ' person', 'tu.person_id = person.id');
        $query->leftJoin($addressTable . ' address', 'address.relatedmodel_id = person.id AND address.relatedmodel = :rm', [':rm' => 'Person']);
        $query->where('tu.id != :id AND tu.type = :type', [':id' => User::SUPER_USER_ID, ':type' => 'system']);
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
        $query->andFilterWhere(['like', 'tu.username', $this->username]);
        $query->andFilterWhere(['tu.status' => $this->status]);
        $query->andFilterWhere(['tu.timezone' => $this->timezone]);
        $query->andFilterWhere(['like', 'person.firstname', $this->firstname]);
        $query->andFilterWhere(['like', 'person.lastname', $this->lastname]);
        $query->andFilterWhere(['like', 'person.email', $this->email]);
        $query->andFilterWhere(['like', 'address.address1', $this->address1]);
        if($this->canAccessOwnedRecordsOnly('user'))
        {
            $query->andFilterWhere(['tu.created_by' => $this->getUserId()]);
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
