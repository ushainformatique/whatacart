<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\orderstatus\business;

use common\modules\localization\modules\orderstatus\dao\OrderStatusDAO;
use yii\base\InvalidParamException;
/**
 * Manager class file.
 *
 * @package common\modules\localization\modules\orderstatus\business
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return OrderStatusDAO::getAll($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model      = OrderStatusDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Id is not valid: $id");
        }
        return $model;
    }
}