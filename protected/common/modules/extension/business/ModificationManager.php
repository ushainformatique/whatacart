<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\business;

use common\modules\extension\models\Extension;
/**
 * ModificationManager class file.
 * 
 * @package common\modules\extension\business
 */
class ModificationManager extends \usni\library\business\Manager
{
    /**
     * inheritdoc
     */
    public function processList($gridViewDTO)
    {
        $gridViewDTO->getSearchModel()->category = 'modification';
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
