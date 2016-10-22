<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\views;

use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
use common\utils\ApplicationUtil;
/**
 * CheckoutView class file.
 * 
 * @package cart\views
 */
class CheckoutView extends AdminCheckoutView
{   
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $innerContent = parent::renderContent();
        $theme        = FrontUtil::getThemeName();
        $file         = UsniAdaptor::getAlias('@themes/' . $theme . '/views/layouts/innerpage') . '.php';
        return $this->getView()->renderPhpFile($file, ['columnLeft' => null,
                                                                'columnRight'=> null,
                                                                'content'    => $innerContent
                                                               ]);
    }
    
    /**
     * @inheritdoc
     */
    public function resolveFormViewPath()
    {
        $theme = FrontUtil::getThemeName();
        return "@themes/$theme/views/cart/checkout";
    }
    
    /**
     * @inheritdoc
     */
    protected function getSource()
    {
        return 'front';
    }
    
    /**
     * @inheritdoc
     */
    public static function getFormId()
    {
        return 'checkout-form';
    }
    
    /**
     * @inheritdoc
     */
    protected function getCustomerId()
    {
        return ApplicationUtil::getCustomerId();
    }
}