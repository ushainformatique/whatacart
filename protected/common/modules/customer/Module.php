<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer;

use usni\library\components\UiSecuredModule;
use usni\UsniAdaptor;
use customer\utils\CustomerPermissionUtil;
use customer\models\Customer;
use customer\views\LatestCustomerGridView;
use usni\library\components\UiHtml;
/**
 * Loads the customer module in the system.
 * @package customer
 */
class Module extends UiSecuredModule
{

    const CUSTOMER_GROUP = 'customer';

    /**
     * Overrides to register translations.
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    /**
     * Registers translations.
     */
    public function registerTranslations()
    {
        UsniAdaptor::app()->i18n->translations['customer*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['customerflash*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['customerflash*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getPermissionUtil()
    {
        return CustomerPermissionUtil::className();
    }
    
    /**
     * Gets dashboard content.
     * @return string
     */
    public function getDashboardContent()
    {
        $customer   = new Customer();
        $view       = new LatestCustomerGridView(['model' => $customer]);
        $content    = UiHtml::panelContent($view->render(), ['class' => 'panel-dashboard']);
        return UiHtml::tag('div', $content, ['class' => 'col-sm-6 col-xs-12']);
    }
}
?>