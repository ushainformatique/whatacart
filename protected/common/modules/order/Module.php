<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order;

use usni\library\components\UiSecuredModule;
use usni\UsniAdaptor;
use common\modules\order\utils\OrderPermissionUtil;
use common\modules\order\models\Order;
use common\modules\order\views\LatestOrderGridView;
use usni\library\components\UiHtml;
/**
 * Provides functionality related to order.
 *
 * @package common\modules\order
 */
class Module extends UiSecuredModule
{  
    public $controllerNamespace = 'common\modules\order\controllers';
    
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
        UsniAdaptor::app()->i18n->translations['order*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/messages'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getPermissionUtil()
    {
        return OrderPermissionUtil::className();
    }
    
    /**
     * Gets dashboard content.
     * @return string
     */
    public function getDashboardContent()
    {
        $model      = new Order();
        $view       = new LatestOrderGridView(['model' => $model]);
        $content    = UiHtml::panelContent($view->render(), ['class' => 'panel-dashboard']);
        return UiHtml::tag('div', $content, ['class' => 'col-sm-6 col-xs-12']);
    }
}
?>