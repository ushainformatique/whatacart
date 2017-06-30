<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\stockstatus\business;

use common\modules\localization\modules\stockstatus\dao\StockStatusDAO;
use yii\base\InvalidParamException;
/**
 * StockStatusManager class file.
 *
 * @package common\modules\localization\modules\stockstatus\business
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return StockStatusDAO::getAll($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model  = StockStatusDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Id is not valid: $id");
        }
        return $model;
    }
}