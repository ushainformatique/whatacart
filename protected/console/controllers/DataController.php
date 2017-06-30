<?php
namespace console\controllers;

use yii\console\Controller;
use usni\UsniAdaptor;
use usni\library\modules\users\models\User;
/**
 * Run datamanager and install the data
 *
 * The command would be as follows yii data/index {managerClassName}.
 * managerClassName should be passed with forward slash for example common/managers/AuthDataManager.
 * In case you run for a data manager like UsersDataManager which has notification data, you need to first delete it manually.
 * 
 * @package console\controllers
 */
class DataController extends Controller
{
    /**
     * Run data manager and add data
     * @param string $managerClassName
     */
    public function actionIndex($managerClassName)
    {
        $managerClassName   = str_replace('/', '\\', $managerClassName);
        $modelClassName     = $managerClassName::getModelClassName();
        //Delete existing records
        if($modelClassName != null)
        {
            $records            = $modelClassName::find()->all();
            foreach($records as $record)
            {
                if($modelClassName == User::className())
                {
                    if($record->id == User::SUPER_USER_ID || $record->username == 'storeowner')
                    {
                        continue;
                    }
                }
                $record->delete();
            }
        }
        $managerClassName::getInstance()->loadDefaultData();
        $managerClassName::getInstance()->loadDemoData();
    }
}
