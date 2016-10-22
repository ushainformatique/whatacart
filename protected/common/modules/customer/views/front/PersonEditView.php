<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use usni\UsniAdaptor;
/**
 * PersonEditView class file.
 * 
 * @package customer\views\front
 */
class PersonEditView extends \usni\library\modules\users\views\PersonEditView
{
    /**
     * @inheritdoc
     */
    public function getExcludedAttributes()
    {
        $scenario   = $this->model->scenario;
        if ($scenario == 'registration')
        {
            return ['profile_image'];
        }
        return [];
    }
    
    /**
     * @inheritdoc
     */
    protected function getDeleteImageUrl()
    {
        return UsniAdaptor::createUrl('customer/site/delete-image');
    }
}