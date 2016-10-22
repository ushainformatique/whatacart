<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\marketing\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\ButtonsUtil;
use usni\library\components\UiActiveForm;
use marqu3s\summernote\Summernote;
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use usni\library\utils\DAOUtil;
use common\modules\stores\models\Store;
use customer\utils\CustomerUtil;
use products\models\Product;
use usni\library\modules\auth\models\Group;
use common\modules\marketing\utils\MarketingUtil;
use usni\library\utils\FlashUtil;
use customer\models\Customer;
/**
 * SendMailEditView class file.
 * @package common\modules\marketing\views
 */
class SendMailEditView extends UiBootstrapEditView
{

    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $group  = new Group();
        $parent = Group::find()->joinWith('translations')->where('name = :name AND language = :language', 
                                                                [':name' => Customer::CUSTOMER_GROUP_NAME, ':language' => 'en-US'])->one();
        $elements = [
                        'store_id'      => UiHtml::getFormSelectFieldOptionsWithNoSearch(DAOUtil::getDropdownDataBasedOnModel(Store::className())),
                        'to'            => UiHtml::getFormSelectFieldOptions(MarketingUtil::getToNewsletterDropdown()),
                        'customer_id'   => UiHtml::getFormSelectFieldOptionsWithNoSearch(CustomerUtil::getDropdownDataBasedOnModel(), ['closeOnSelect' => false], ['multiple' => 'multiple']),
                        //This is for customer group.
                        'group_id' =>   UiHtml::getFormSelectFieldOptions($group->getMultiLevelSelectOptions('name', $parent->id, '-', true, $this->shouldRenderOwnerCreatedModels()), ['closeOnSelect' => false], ['multiple' => 'multiple']),
                        'product_id'    => UiHtml::getFormSelectFieldOptions(DAOUtil::getDropdownDataBasedOnModel(Product::className()), ['closeOnSelect' => false], ['multiple' => 'multiple']),
                        'subject'       => ['type' => 'text'],
                        'content'       => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => Summernote::className()],
                    ];
        $metadata = [
                        'elements'  => $elements,
                        'buttons'   => self::getDefaultButtonsMetadata()
                    ];
        return $metadata;
    }
    
    /**
     * Get default buttons metadata.
     * @param string $cancelUrl Cancel Url.
     * @param string $buttonId.
     * @return array
     */
    public static function getDefaultButtonsMetadata()
    {
        return [
                    'save'   => ButtonsUtil::getSubmitButton(UsniAdaptor::t('application', 'Send')),
                ];
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('newsletter', 'Send Mail');
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        parent::registerScripts();
        $js = "$(document).ready(function() {
                 $('.field-sendmailform-group_id').hide();
                 $('.field-sendmailform-customer_id').hide();
                 $('.field-sendmailform-product_id').hide();
               });";
        $this->getView()->registerJs($js);
        $js = "     
                    $('body').on('change', '#sendmailform-to', function(){
                    var dropdownVal = $(this).val();
                    if(dropdownVal == 1)
                    {
                        $('.field-sendmailform-group_id').hide();
                        $('.field-sendmailform-customer_id').hide();
                        $('.field-sendmailform-product_id').hide();
                    }
                    if(dropdownVal == 2)
                    {
                        $('.field-sendmailform-group_id').show();
                        $('.field-sendmailform-customer_id').hide();
                        $('.field-sendmailform-product_id').hide();
                    }
                    if(dropdownVal == 3)
                    {
                        $('.field-sendmailform-group_id').hide();
                        $('.field-sendmailform-customer_id').show();
                        $('.field-sendmailform-product_id').hide();
                    }
                    if(dropdownVal == 4)
                    {
                        $('.field-sendmailform-group_id').hide();
                        $('.field-sendmailform-customer_id').hide();
                        $('.field-sendmailform-product_id').show();
                    }
               })";
        $this->getView()->registerJs($js, \yii\web\View::POS_END);
    }
    
    /**
     * @inheritdoc
     */
    protected function renderFlashMessages()
    {
        return FlashUtil::render('sendMail', 'alert alert-success');
    }
}
?>