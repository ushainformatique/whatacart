<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\business\free;

use common\modules\extension\models\Extension;
/**
 * Manager class file.
 * 
 * @package common\modules\shipping\business\free
 */
class Manager extends \common\modules\shipping\business\Manager
{
    /**
     * Process change status.
     * @param integer $id
     * @param integer $status
     */
    public function processChangeStatus($id, $status)
    {
        if($this->checkIfShippingMethodAllowedToDeactivate('free') == false)
        {
            return false;
        }
        $extension          = Extension::findOne($id);
        $extension->status  = $status;
        $extension->save();
        return true;
    }
}
