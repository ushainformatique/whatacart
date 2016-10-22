<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\views\common;

use usni\library\views\UiView;
use usni\UsniAdaptor;
use frontend\utils\FrontUtil;
use newsletter\views\SendNewsletterView;
use newsletter\models\NewsletterCustomers;
use usni\library\utils\ConfigurationUtil;
/**
 * FooterView class file.
 * @package frontend\views\common
 */
class FooterView extends UiView
{
    /**
     * Render content.
     * @return string 
     */
    protected function renderContent()
    {
        $themeName       = FrontUtil::getThemeName();
        $file            = UsniAdaptor::getAlias('@themes/' . $themeName . '/views/common/_footer') . '.php';
        $content         = $this->getView()->renderPhpFile($file, ['columnLeft' => null,
                                                                   'columnRight'=> null,
                                                                   'powered'   => $this->renderFooterContent()
                                                                   ]);
        $isEnabled = ConfigurationUtil::isModuleEnabled('marketing');
        if($isEnabled)
        {
            $sendNewsletterView = new SendNewsletterView(new NewsletterCustomers(['scenario' => 'send']));
            return $content . $sendNewsletterView->render();
        }
        return $content;
        
    }
    
    /**
     * Render footer content.
     * @return string
     */
    protected function renderFooterContent()
    {
        $storeName      = null;
        $currentStore   = UsniAdaptor::app()->storeManager->getCurrentStore();
        if($currentStore->name == 'Default')
        {
            $storeName  = UsniAdaptor::t('stores', 'Default Store');
        }
        else
        {
            $storeName = $currentStore->name;
        }
        return '<p>Copyright &copy; ' . 
        date("Y") . " " . $storeName . '. All Rights Reserved.
        ' . UsniAdaptor::app()->powered() . '</p>';
    }
}
