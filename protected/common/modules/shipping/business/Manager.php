<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\business;

use common\modules\extension\models\Extension;
use usni\UsniAdaptor;
use usni\library\utils\FileUtil;
use common\modules\stores\business\ConfigManager;
/**
 * Manager class file.
 * 
 * @package common\modules\shipping\business
 */
class Manager extends \common\business\Manager
{
    use \common\modules\shipping\traits\ShippingTrait;
    
    /**
     * inheritdoc
     */
    public function processList($gridViewDTO) 
    {
        $gridViewDTO->getSearchModel()->category = 'shipping';
        parent::processList($gridViewDTO);
    }
    
    /**
     * Process reload.
     */
    public function processReload()
    {
        $shippingMethods    = Extension::find()->where('category = :category', [':category' => 'shipping'])->all();
        $installedCodes     = [];
        foreach($shippingMethods as $shipping)
        {
            $installedCodes[] = $shipping->code;
        }
        $path       = UsniAdaptor::getAlias('@common/modules/shipping/config');
        $subDirs    = glob($path . '/*', GLOB_ONLYDIR);
        //If newly added
        foreach($subDirs as $subDir)
        {
            $subPath    = FileUtil::normalizePath($subDir);
            $data       = require($subPath . '/config.php');
            //If not in db
            if(!in_array($data['code'], $installedCodes))
            {
                $extension = new Extension(['scenario' => 'create']);
                $extension->setAttributes($data);
                if($extension->save())
                {
                    $installedCodes[] = $data['code'];
                }
            }
        }
        //if folder is removed
        foreach($installedCodes as $code)
        {
            $folderPath = FileUtil::normalizePath($path . '/' . $code);
            if(!file_exists($folderPath))
            {
                $shipping = Extension::find()->where('code = :code AND category = :category', [':category' => 'shipping', ':code' => $code])->one();
                $shipping->delete();
                //Delete store configuration
                ConfigManager::getInstance()->deleteStoreConfiguration($code, 'shipping');
            }
        }
    }
}
