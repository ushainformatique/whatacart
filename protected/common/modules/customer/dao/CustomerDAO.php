<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
use usni\library\modules\users\models\Address;
/**
 * Implements data access functionality related to customer.
 *
 * @package customer\dao
 */
class CustomerDAO extends \yii\base\Component
{
    /**
     * Get address by type
     * @param int $customerId
     * @param int $type
     * @return type
     */
    public static function getAddressByType($customerId, $type)
    {
        $addressTblName = UsniAdaptor::tablePrefix() . 'address';
        $custTblName    = UsniAdaptor::tablePrefix() . 'customer';
        $sql            = "SELECT * FROM $addressTblName addr, $custTblName cust  WHERE cust.id = :cid "
                            . "AND cust.person_id = addr.relatedmodel_id AND addr.relatedmodel = :rm AND type = :type";
        $dependency     = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $custTblName"]);
        return UsniAdaptor::app()->db->createCommand($sql, [':rm' => 'Person', ':cid' => $customerId, ':type' => $type])->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get customer group by name
     * @param string $name
     * @param string $language
     * @return array
     */
    public static function getCustomerGroupByName($name)
    {
        $groupTable     = UsniAdaptor::tablePrefix() . 'group';
        $dependency     = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $groupTable"]);
        $sql            = "SELECT * FROM $groupTable
                            WHERE name = :name";
        $connection     = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':name' => $name])->cache(0, $dependency)->queryOne(); 
    }
    
    /**
     * Get customer by email
     * @param string $email
     * @return array
     */
    public static function getCustomerByEmail($email)
    {
        $connection             = UsniAdaptor::app()->getDb();
        $tableName              = $connection->tablePrefix . 'customer';
        $peTableName            = $connection->tablePrefix . 'person';
        $adTableName            = $connection->tablePrefix . 'address';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        $sql                    = "SELECT u.*, pe.firstname, pe.lastname, pe.email, pe.mobilephone, pe.profile_image,
                                   ad.address1, ad.address2, ad.city, ad.state, ad.country, ad.postal_code
                                   FROM $tableName u, $peTableName pe, $adTableName ad 
                                   WHERE pe.email = :email AND pe.id = u.person_id AND pe.id = ad.relatedmodel_id AND ad.relatedmodel = :rm 
                                   AND ad.type = :type";
        return $connection->createCommand($sql, [':email' => $email, ':rm' => 'Person', ':type' => Address::TYPE_DEFAULT])
                          ->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get customer by id.s
     * @param int $id
     * @return array
     */
    public static function getById($id)
    {
        $connection             = UsniAdaptor::app()->getDb();
        $tableName              = $connection->tablePrefix . 'customer';
        $peTableName            = $connection->tablePrefix . 'person';
        $adTableName            = $connection->tablePrefix . 'address';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        $sql                    = "SELECT u.*, pe.firstname, pe.lastname, pe.email, pe.mobilephone, pe.profile_image,
                                   ad.address1, ad.address2, ad.city, ad.state, ad.country, ad.postal_code
                                   FROM $tableName u, $peTableName pe, $adTableName ad 
                                   WHERE u.id = :id AND pe.id = u.person_id AND pe.id = ad.relatedmodel_id AND ad.relatedmodel = :rm 
                                   AND ad.type = :type";
        return $connection->createCommand($sql, [':id' => $id, ':rm' => 'Person', ':type' => Address::TYPE_DEFAULT])
                          ->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get customer by group id.
     * @param integer $groupId
     * @return array
     */
    public static function getCustomerByGroupId($groupId)
    {
        $groupMemberTable   = UsniAdaptor::tablePrefix() . 'group_member';
        $customerTable      = UsniAdaptor::tablePrefix() . 'customer';
        $personTable        = UsniAdaptor::tablePrefix() . 'person';
        $addressTable       = UsniAdaptor::tablePrefix() . 'address';
        $sql                = "SELECT ct.*, pt.firstname, pt.lastname, pt.email, pt.mobilephone, pt.profile_image,
                               at.address1, at.address2, at.city, at.state, at.country, at.postal_code
                               FROM $customerTable ct, $personTable pt, $addressTable at, $groupMemberTable gmt "
                             . "WHERE gmt.group_id = :gid AND gmt.member_type = :mtype AND gmt.member_id = ct.id AND ct.person_id = pt.id AND pt.id = at.relatedmodel_id AND at.                                   relatedmodel = :rm AND at.type = :type";
        $params             = [':gid' => $groupId, ':mtype' => 'customer', ':rm' => 'Person', ':type' => Address::TYPE_DEFAULT];
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, $params)->queryAll();
    }
    
    /**
     * Gets customer group by tax rule details.
     * @param $id integer tax rule id
     * @return array
     */
    public static function getCustomerGroupByTaxRuleDetails($id)
    {  
       $groupTable            = UsniAdaptor::tablePrefix() . 'group';
       $taxRuleDetailsTable   = UsniAdaptor::tablePrefix() . 'tax_rule_details';
       $sql                   = "SELECT DISTINCT tg.name
                                 FROM $groupTable tg, $taxRuleDetailsTable ttrd
                                 WHERE ttrd.tax_rule_id = :trid AND ttrd.customer_group_id = tg.id";
        $connection    = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':trid' => $id])->queryAll();
    }
    
    /**
     * Get all customers.
     * @return array
     */
    public static function getAll()
    {
        $table      = UsniAdaptor::tablePrefix() . 'customer';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT * FROM $table";
        return UsniAdaptor::app()->db->createCommand($sql)->cache(0, $dependency)->queryAll();
    }
}
