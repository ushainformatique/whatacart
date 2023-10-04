<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\models;

use yii\data\Sort;
use usni\library\modules\users\models\User;
use usni\library\dataproviders\ArrayRecordDataProvider;
use usni\UsniAdaptor;
/**
 * LatestUserSearch class file
 *
 * @package usni\library\modules\users\models
 */
class LatestUserSearch extends UserSearchForm
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return User::tableName();
    }
    
    /**
     * @inheritdoc
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
        $query->where('tu.id != :id AND tu.type = :type', [':id' => User::SUPER_USER_ID, ':type' => 'system'])
              ->limit(5)
              ->orderBy('tu.created_datetime DESC');

        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }
        if($this->canAccessOwnedRecordsOnly('user'))
        {
            $query->andFilterWhere(['tu.created_by' => $this->getUserId()]);
        }
        $dataProvider->setPagination(false);
        return $dataProvider;
    }
}
