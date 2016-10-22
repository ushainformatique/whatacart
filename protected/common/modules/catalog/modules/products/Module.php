<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products;

use usni\library\components\UiSecuredModule;
use usni\UsniAdaptor;
use products\models\Product;
use products\views\LatestProductGridView;
use usni\library\components\UiHtml;
/**
 * Loads the products module in the system.
 *
 * @package product
 */
class Module extends UiSecuredModule
{
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
        UsniAdaptor::app()->i18n->translations['products*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['productflash*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['productshint*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
    }
    
    /**
     * Gets dashboard content.
     * @return string
     */
    public function getDashboardContent()
    {
        $product   = new Product();
        $view      = new LatestProductGridView(['model' => $product]);
        $content   = UiHtml::panelContent($view->render(), ['class' => 'panel-dashboard']);
        return UiHtml::tag('div', $content, ['class' => 'col-sm-6 col-xs-12']);
    }
}
?>