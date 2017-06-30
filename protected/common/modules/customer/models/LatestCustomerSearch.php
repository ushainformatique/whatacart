<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\models;

use customer\models\Customer;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * LatestCustomerSearch class file
 *
 * @package customer\models
 */
class LatestCustomerSearch extends CustomerSearchForm
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Customer::tableName();
    }
    
    /**
     * @inheritdoc
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
        $query->orderBy('tc.created_datetime DESC');
        $query->limit(5);
        
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }
        if($this->canAccessOwnedRecordsOnly('customer'))
        {
            $query->andFilterWhere(['tc.created_by' => $this->getUserId()]);
        }
        $dataProvider->setPagination(false);
        return $dataProvider;
    }
}
