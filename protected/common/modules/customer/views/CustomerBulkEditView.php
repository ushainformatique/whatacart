<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\views;

use usni\library\extensions\bootstrap\views\UiBootstrapBulkEditView;
use usni\library\components\UiHtml;
use usni\library\utils\TimezoneUtil;
use usni\library\utils\CountryUtil;
use usni\library\modules\auth\models\Group;
use usni\library\modules\users\models\User;
use usni\UsniAdaptor;
use customer\utils\CustomerUtil;
/**
 * CustomerBulkEditView class file.
 * 
 * @package customer\views
 */
class CustomerBulkEditView extends UiBootstrapBulkEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $group      = new Group();
        $parent     = Group::find()->joinWith('translations')->where('name = :name AND language = :language', 
                                                                [':name' => CustomerUtil::getDefaultGroupTitle(), ':language' => 'en-US'])->one();
        $elements = [
                            'status'          => UiHtml::getFormSelectFieldOptionsWithNoSearch(User::getStatusDropdown()),
                            'timezone'        => UiHtml::getFormSelectFieldOptions(TimezoneUtil::getTimezoneSelectOptions(),
                                                                                   [], ['placeholder' => UiHtml::getDefaultPrompt()]),
                            'groups'          => UiHtml::getFormSelectFieldOptions($group->getMultiLevelSelectOptions('name', $parent->id, '-', true, $this->shouldRenderOwnerCreatedModels()),
                                                                                   [], ['multiple' => true]),
                            'city'            => array('type' => 'text'),
                            'state'           => array('type' => 'text'),
                            'country'         => UiHtml::getFormSelectFieldOptions(CountryUtil::getCountries()),
                            'postal_code'     => array('type' => 'text'),
                    ];
        $metadata = [
                            'elements'              => $elements,
                            'buttons'               => $this->getSubmitButton()
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
         return UsniAdaptor::t('customer', 'Customer Bulk Edit');
    }
    
    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        return [
            'city' => ['inputOptions'  => ['disabled' => 'disabled']],
            'state' => ['inputOptions'  => ['disabled' => 'disabled']],
            'postal_code' => ['inputOptions'  => ['disabled' => 'disabled']],
        ];
    }

}