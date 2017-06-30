<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\db;

use usni\library\db\DataManager;
use usni\UsniAdaptor;
use common\modules\extension\models\Extension;
use usni\library\utils\FileUtil;
use usni\library\modules\users\models\User;
/**
 * Loads default data related to payment.
 *
 * @package common\modules\payment\db
 */
class PaymentDataManager extends DataManager
{   
    /**
     * @inheritdoc
     */
    public function loadDefaultData()
    {
        $path       = UsniAdaptor::getAlias('@common/modules/payment/config');
        $subDirs    = glob($path . '/*', GLOB_ONLYDIR);
        foreach($subDirs as $subDir)
        {
            $subPath    = FileUtil::normalizePath($subDir);
            $data       = require($subPath . '/config.php');
            $extension  = new Extension(['scenario' => 'create']);
            $extension->setAttributes($data);
            $extension->created_by = $extension->modified_by = User::SUPER_USER_ID; 
            $extension->save();
            $extension->saveTranslatedModels();
        }
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return null;
    }
}