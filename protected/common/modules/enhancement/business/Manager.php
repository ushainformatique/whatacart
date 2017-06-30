<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\enhancement\business;

use common\modules\extension\models\Extension;
/**
 * Manager class file.
 * 
 * @package common\modules\enhancement\business
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * inheritdoc
     */
    public function processList($gridViewDTO)
    {
        $gridViewDTO->getSearchModel()->category = 'enhancement';
        parent::processList($gridViewDTO);
    }
    
    /**
     * Process change status.
     * @param integer $id
     * @param integer $status
     */
    public function processChangeStatus($id, $status)
    {
        $extensions         = Extension::findOne($id);
        $extensions->status = $status;
        $extensions->save();
    }
}
