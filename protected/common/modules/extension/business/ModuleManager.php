<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\business;

use common\modules\extension\models\Extension;
/**
 * ModuleManager class file.
 * 
 * @package common\modules\extension\business
 */
class ModuleManager extends \usni\library\business\Manager
{
    /**
     * inheritdoc
     */
    public function processList($gridViewDTO)
    {
        $gridViewDTO->getSearchModel()->category = 'module';
        parent::processList($gridViewDTO);
    }
    
    /**
     * Process change status.
     * @param integer $id
     * @param integer $status
     */
    public function processChangeStatus($id, $status)
    {
        $extension          = Extension::findOne($id);
        $extension->status  = $status;
        $extension->save();
    }
}
