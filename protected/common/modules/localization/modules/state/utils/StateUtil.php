<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\utils;

use usni\UsniAdaptor;
use common\modules\localization\modules\state\models\State;
use usni\library\utils\ArrayUtil;
use taxes\utils\TaxUtil;
/**
 * StateUtil contains utility functions related to state
 * 
 * @package common\modules\localization\modules\state\utils
 */
class StateUtil
{
    /**
     * Get states by country id.
     * @param int $countryId
     * @return array
     */
    public static function getStatesOptionByCountryId($countryId)
    {
        $str = null;
        $states = State::find()->where('country_id = :cid', [':cid' => $countryId])->all();
        $dropdownData = ArrayUtil::map($states, 'id', 'name');
        return ArrayUtil::merge([-1 => UsniAdaptor::t('localization', 'All States')], $dropdownData);
    }
    
    /**
     * Check if state is allowed to delete.
     * @param State $model
     * @return boolean
     */
    public static function checkIfStateAllowedToDelete($model)
    {
        $zone   = TaxUtil::getZoneByAttribute('state_id', $model['id']);
        if(empty($zone))
        {
            return true;
        }
        return false;
    }
    
    /**
     * Get state based on name, language and country.
     * @param State $state
     * @param string $language
     * @return array
     */
    public static function getStateBasedOnNameLanguageAndCountry($state, $language = null)
    {
        if($language == null)
        {
            $language           = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $stateTable             = UsniAdaptor::tablePrefix() . 'state';
        $trStateTable           = UsniAdaptor::tablePrefix() . 'state_translated';
        $trCountryTable         = UsniAdaptor::tablePrefix() . 'country_translated';
        $sql                    = "SELECT st.*, tst.name, tct.name as country_name
                                   FROM $stateTable st, $trStateTable tst, $trCountryTable tct
                                   WHERE st.country_id = :cid AND st.id = tst.owner_id AND tst.name = :name AND tst.language = :lang AND 
                                   tct.owner_id = :coid AND tct.language = :clang";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':cid' => $state->country_id, ':name' => $state->name, ':lang' => $language, ':coid' => $state->country_id, 
                                   ':clang' => $language];
        $record                 = $connection->createCommand($sql, $params)->queryOne();
        return $record;
    }
}
