<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\state\dao;

use yii\caching\DbDependency;
use usni\UsniAdaptor;
/**
 * StateDAO class file.
 * 
 * @package common\modules\localization\modules\state\dao
 */
class StateDAO
{
    /**
     * Get all states.
     * @param string $language
     * @param integer $status
     * @return array
     */
    public static function getAll($language, $status = null)
    {
        $table      = UsniAdaptor::tablePrefix() . 'state';
        $trTable    = UsniAdaptor::tablePrefix() . 'state_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT s.*, st.name FROM $table s, $trTable st "
                    . "WHERE s.id = st.owner_id AND st.language = :lang";
        $params     = [];
        if($status != null)
        {
            $sql .= " AND s.status = :status";
            $params[':status'] = $status;
        }
        $params[':lang'] = $language;
        return UsniAdaptor::app()->db->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get by id.
     * @param integer $id
     * @param string $language
     * @return array
     */
    public static function getById($id, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'state';
        $trTable    = UsniAdaptor::tablePrefix() . 'state_translated';
        $sql        = "SELECT s.*, st.name FROM $table s, $trTable st "
                    . "WHERE s.id = :id AND st.owner_id = s.id AND st.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
    
    /**
     * Get state based on name, language and country.
     * @param int $countryId
     * @param string $name
     * @param string $language
     * @return array
     */
    public static function getStateBasedOnNameLanguageAndCountry($countryId, $name, $language)
    {
        $stateTable             = UsniAdaptor::tablePrefix() . 'state';
        $trStateTable           = UsniAdaptor::tablePrefix() . 'state_translated';
        $trCountryTable         = UsniAdaptor::tablePrefix() . 'country_translated';
        $sql                    = "SELECT st.*, tst.name, tct.name as country_name
                                   FROM $stateTable st, $trStateTable tst, $trCountryTable tct
                                   WHERE st.country_id = :cid AND st.id = tst.owner_id AND tst.name = :name AND tst.language = :lang AND 
                                   tct.owner_id = :coid AND tct.language = :clang";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':cid' => $countryId, ':name' => $name, ':lang' => $language, ':coid' => $countryId, 
                                   ':clang' => $language];
        return $connection->createCommand($sql, $params)->queryOne();
    }
    
    /**
     * Get state by country.
     * @param int $countryId
     * @param string $language
     * @return array
     */
    public static function getStateByCountry($countryId, $language)
    {
        $stateTable             = UsniAdaptor::tablePrefix() . 'state';
        $trStateTable           = UsniAdaptor::tablePrefix() . 'state_translated';
        $sql                    = "SELECT st.*, tst.name
                                   FROM $stateTable st, $trStateTable tst
                                   WHERE st.country_id = :cid AND st.id = tst.owner_id AND tst.language = :lang";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':cid' => $countryId, ':lang' => $language];
        return $connection->createCommand($sql, $params)->queryAll();
    }
}
