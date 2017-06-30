<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\business;

use usni\UsniAdaptor;
use common\modules\cms\models\Page;
use common\modules\cms\dao\PageDAO;
use yii\base\InvalidParamException;
/**
 * Manager class file.
 *
 * @package common\modules\cms\business
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * inheritdoc
     */
    public function processEdit($formDTO)
    {
        parent::processEdit($formDTO);
        $parentDropdownOptions = $this->getMultiLevelSelectOptions($formDTO->getModel());
        $formDTO->setParentDropdownOptions($parentDropdownOptions);
    }
    
    /**
     * Get multi level select options.
     * @param Group $model
     * @return array
     */
    public function getMultiLevelSelectOptions($model)
    {
        if($model->isNewRecord)
        {
            $model->created_by = $this->userId;
        }
        $isOthersAllowed  = UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, 'page.updateother');
        return $model->getMultiLevelSelectOptions('name', !$isOthersAllowed);
    }
    
    /**
     * inheritdoc
     */
    public function processList($gridViewDTO)
    {
        parent::processList($gridViewDTO);
        $model = new Page();
        $parentDropdownOptions = $this->getMultiLevelSelectOptions($model);
        $gridViewDTO->setParentDropdownOptions($parentDropdownOptions);
    }
    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return PageDAO::getAllPages($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model  = PageDAO::getById($id, $this->language);
        if (empty($model))
        {
            throw new InvalidParamException("Object not found: $id");
        }
        $parentName = PageDAO::getParentName($model['parent_id'], $this->language);
        if($model['parent_id'] == 0 || empty($parentName) )
        {
            $model['parent'] = UsniAdaptor::t('application', '(not set)');
        }
        else
        {
            $model['parent'] = $parentName;
        }
        return $model;
    }
}
