<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\dao;

use usni\UsniAdaptor;
use usni\library\modules\users\models\User;
use yii\caching\DbDependency;
use usni\library\modules\users\models\Address;
/**
 * UserDAO class file.
 * 
 * @package usni\library\modules\users\dao
 */
class UserDAO
{
    /**
     * Activates user.
     * @param string $hash
     * @param string $email
     * @return boolean
     */
    public static function activateUser($tableName, $hash, $email)
    {
        $hash          = base64_decode($hash);
        $query         = new \yii\db\Query();
        $personTable   = UsniAdaptor::app()->db->tablePrefix . 'person';
        $user          = $query->select('tu.*, tp.email')->from($tableName . ' tu, ' . $personTable . ' tp')
                            ->where('tu.password_hash = :ph AND tu.person_id = tp.id')->params([':ph' => $hash])->one();
        if($user['email'] == $email)
        {
            $data   = ['status' => User::STATUS_ACTIVE, 'modified_by' => User::SUPER_USER_ID, 'modified_datetime' => date('Y-m-d H:i:s')];
            $result = UsniAdaptor::app()->db->createCommand()->update($tableName, $data, 'id = :id', [':id' => $user['id']])->execute();
            if($result)
            {
                return $user;
            }
        }
        return false;
    }
    
    /**
     * Get user by id
     * @return array
     */
    public static function getById($id)
    {
        $connection             = UsniAdaptor::app()->getDb();
        $tableName              = $connection->tablePrefix . 'user';
        $peTableName            = $connection->tablePrefix . 'person';
        $adTableName            = $connection->tablePrefix . 'address';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName WHERE id = :id", 'params' => [':id' => $id]]);
        $sql                    = "SELECT u.*, pe.firstname, pe.lastname, pe.email, pe.mobilephone, pe.profile_image,
                                   ad.address1, ad.address2, ad.city, ad.state, ad.country, ad.postal_code
                                   FROM $tableName u, $peTableName pe, $adTableName ad 
                                   WHERE u.id = :uid AND u.person_id = pe.id AND pe.id = ad.relatedmodel_id AND ad.relatedmodel = :rm AND ad.type = :type";
        return $connection->createCommand($sql, [':uid' => $id, ':rm' => 'Person', ':type' => Address::TYPE_DEFAULT])
                          ->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get all useres
     * @return array
     */
    public static function getAll()
    {
        $table      = UsniAdaptor::tablePrefix() . 'user';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT * FROM $table";
        return UsniAdaptor::app()->db->createCommand($sql)->cache(0, $dependency)->queryAll();
    }
}