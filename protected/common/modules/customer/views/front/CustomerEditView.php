<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views\front;

use customer\views\CustomerEditView as BaseCustomerView;
use usni\library\components\UiActiveForm;
use customer\models\Customer;
use common\modules\stores\utils\StoreUtil;
/**
 * CustomerEditView class file.
 * @package customer\views\front
 */
class CustomerEditView  extends BaseCustomerView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $metadata       = parent::getFormBuilderMetadata();
        if($this->model->scenario == 'registration')
        {
            $status = Customer::STATUS_PENDING;
        }
        else
        {
            $status = $this->model->status;
            $metadata['elements']['username'] = ['type' => UiActiveForm::INPUT_HIDDEN, 'value' => $this->model->username];
        }
        $metadata['elements']['status'] = ['type' => UiActiveForm::INPUT_HIDDEN, 'value' => $status];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function getCustomerGroups()
    {
        $customerGroup  = StoreUtil::getSettingValue('default_customer_group');
        return ['type' => UiActiveForm::INPUT_HIDDEN, 'value' => $customerGroup];
    }
}
