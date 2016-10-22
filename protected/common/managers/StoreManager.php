<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\managers;

use common\modules\stores\models\Store;
use usni\library\utils\ArrayUtil;
use usni\UsniAdaptor;
use common\modules\stores\models\StoreTranslated;
use common\modules\stores\utils\StoreUtil;
use usni\library\utils\CookieUtil;
use yii\web\Cookie;
/**
 * StoreManager class file.
 *
 * @package common\managers
 */
class StoreManager
{
    /**
     * The cookie name for the store interface.
     * @var string 
     */
    public $applicationStoreCookieName;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->applicationStoreCookieName == null)
        {
            throw new \yii\base\InvalidConfigException(UsniAdaptor::t('stores', 'missingStoreCookie'));
        }
    }
    
    /**
     * Get allowed stores.
     * @return array
     */
    public static function getAllowed()
    {
        $language         = UsniAdaptor::app()->languageManager->getContentLanguage();
        $tableName        = Store::tableName();
        $trTableName      = StoreTranslated::tableName();
        $sql              = "SELECT st.id, stt.name FROM $tableName st, $trTableName stt
                            WHERE st.status = :status AND st.id = stt.owner_id AND stt.language = :lan";
        $records          = UsniAdaptor::db()->createCommand($sql, [':status' => Store::STATUS_ACTIVE, ':lan' => $language])->queryAll();
        return ArrayUtil::map($records, 'id', 'name');
    }
    
    /**
     * Get default store
     * @return string
     */
    public function getDefaultName()
    {
        $store = StoreUtil::getDefault();
        return $store->name;
    }
    
    /**
     * Get current store
     * @return Store
     */
    public function getCurrentStore()
    {
        $language         = UsniAdaptor::app()->languageManager->getContentLanguage();
        if(YII_ENV != YII_ENV_TEST)
        {
            $tableName        = Store::tableName();
            $trTableName      = StoreTranslated::tableName();
            $query            = (new \yii\db\Query());
            $storeCookieValue = CookieUtil::getValue($this->applicationStoreCookieName);
            $store            = null;
            if($storeCookieValue != null)
            {
                $record = $query->select('s.*, str.name, str.description')->from($tableName . ' s')
                          ->innerJoin($trTableName . ' str', 's.id = str.owner_id')
                          ->where('s.id = :id AND str.language = :lan', [':id' => $storeCookieValue, ':lan' => $language])->one();
                if($record !== false)
                {
                    $store = (object)$record;
                }
            }
            else
            {
                $store = StoreUtil::getDefault();
                $this->setCookie($store->id);
            }
        }
        else
        {
            $store = StoreUtil::getDefault();
        }
        return $store;
    }
    
    /**
     * Sets store cookie.
     * @param string $storeId
     * @return void
     */
    public function setCookie($storeId)
    {
        $cookie = new Cookie([
                                    'name'      => $this->applicationStoreCookieName,
                                    'value'     => $storeId,
                                    'expire'    => time() + 86400 * 2,
                                    'httpOnly'  => true
                                ]);
        UsniAdaptor::app()->getResponse()->getCookies()->add($cookie);
    }
    
    /**
     * Get selected store data category
     * @return string
     */
    public function getSelectedStoreDataCategory()
    {
        $store = $this->getCurrentStore();
        return $store->data_category_id;
    }
}