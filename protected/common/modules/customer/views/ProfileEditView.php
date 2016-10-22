<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views;

use usni\library\modules\users\views\PersonEditView;
use usni\library\modules\users\views\AddressEditView;
use usni\UsniAdaptor;
use usni\library\utils\ButtonsUtil;
use usni\library\components\UiActiveForm;
use customer\views\CustomerEditView;
use usni\library\modules\users\models\Person;
use usni\library\modules\users\models\Address;
use usni\library\utils\ArrayUtil;
/**
 * ProfileEditView class file.
 *
 * @package customer\views
 */
class ProfileEditView extends \usni\library\modules\users\views\ProfileEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $customerView       = $this->renderSubView($this->getCustomerEditView(), $this->model->customer);
        $personView         = $this->renderSubView($this->getPersonEditView(), $this->model->person);
        $addressView        = $this->renderSubView($this->getAddressEditView(), $this->model->address);
        $elements = [
                        'customer'      => ['type' => UiActiveForm::INPUT_RAW, 'value' => $customerView],
                        'person'        => ['type' => UiActiveForm::INPUT_RAW, 'value' => $personView],
                        'address'       => ['type' => UiActiveForm::INPUT_RAW, 'value' => $addressView],
                    ];
        $metadata = [
                        'elements'      => $elements,
                        'buttons'       => ButtonsUtil::getDefaultButtonsMetadata('customer/default/manage')
                    ];
        return $metadata;
    }

    /**
     * @inheritdoc
     */
    protected function renderEditModeBrowseView()
    {
        if($this->model->scenario == 'update')
        {
            $view  = new CustomerEditBrowseModelView(['model' => $this->model->customer, 'attribute' => $this->resolveDefaultBrowseByAttribute()]);
            return $view->render();
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function getTabs()
    {
        return [     
                     'customer'         => ['label'   => UsniAdaptor::t('application', 'General'),
                                            'content' => $this->renderTabElements('customer'),
                                            'linkOptions'   => ['id' => 'customer-tab']],
                     'person'           => ['label'   => Person::getLabel(1),
                                            'content' => $this->renderTabElements('person')],
                     'address'          => ['label'   => Address::getLabel(1),
                                            'content' => $this->renderTabElements('address')],
               ];
    }

    /**
     * @inheritdoc
     */
    protected function getTabElementsMap()
    {
        return [
                    'customer'      => ['customer'],
                    'person'        => ['person'],
                    'address'       => ['address']
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        if($this->model->scenario == 'create')
        {
            return UsniAdaptor::t('application', 'Create') . ' ' . UsniAdaptor::t('customer', 'Customer');
        }
        elseif($this->model->scenario == 'update')
        {
            return UsniAdaptor::t('application', 'Update') . ' ' . UsniAdaptor::t('customer', 'Customer');
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function getModelErrors()
    {
        return ArrayUtil::merge($this->model->customer->getErrors(), $this->model->person->getErrors(), $this->model->address->getErrors());
    }
    
    /**
     * Get customer edit view
     * @return string
     */
    protected function getCustomerEditView()
    {
        return CustomerEditView::className();
    }
    
    /**
     * Get person edit view
     * @return string
     */
    protected function getPersonEditView()
    {
        return PersonEditView::className();
    }
    
    /**
     * Get address edit view
     * @return string
     */
    protected function getAddressEditView()
    {
        return AddressEditView::className();
    }
    
    /**
     * @inheritdoc
     */
    protected function getDefaultButtonOptions()
    {
        $options = parent::getDefaultButtonOptions();
        $options['submit'] = array('class' => 'btn btn-success');
        return $options;
    }
}
?>