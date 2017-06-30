<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\business;

use common\modules\extension\models\Extension;
use usni\library\utils\ArrayUtil;
/**
 * ExtensionManager class file.
 * 
 * @package common\modules\extension\business
 */
class ExtensionManager extends \usni\library\business\Manager
{
    /**
     * Process change status.
     * @param iteger $id
     * @param iteger $status
     */
    public function processChangeStatus($id, $status)
    {
        $extensions         = Extension::findOne($id);
        $extensions->status = $status;
        $extensions->save();
    }
    
    /**
     * Process settings.
     * @param integer $id
     * @return string
     */
    public function processSettings($id)
    {
        $extension = Extension::findOne($id);
        $data      = unserialize($extension->data);
        $settings  = ArrayUtil::getValue($data, 'settings');
        if(!empty($settings))
        {
            $controllerPath = ArrayUtil::getValue($settings, 'controllerPath');
            if(!empty($settings))
            {
                return $controllerPath;
            }
        }
    }
}
