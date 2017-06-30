<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\grid;

use usni\library\grid\ActionToolbar;
use usni\fontawesome\FA;
use usni\library\utils\Html;
use usni\UsniAdaptor;
/**
 * PaymentActionToolbar class file.
 * 
 * @package common\modules\payment\grid
 */
class PaymentActionToolbar extends ActionToolbar
{
    /**
     * Show reload button.
     * @var boolean
     */
    public $showReload = true;
    
    /**
     * inheritdoc
     */
    public $layout = "<div class='block'>
                        <div class='well text-center'>
                            <div class='action-toolbar btn-toolbar'>
                            {perPage}\n{reload}
                            </div>
                        </div>
                      </div>";
    
    /**
     * inheritdoc
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{reload}':
                return $this->renderReloadButton();
        }
        return parent::renderSection($name);
    }
    
    /**
     * Renders reload button
     * @return string
     */
    public function renderReloadButton()
    {
        $userId = UsniAdaptor::app()->user->getIdentity()->getId();
        if($this->showReload && UsniAdaptor::app()->authorizationManager->checkAccess($userId, 'extension.manage'))
        {   
            $link = Html::a(FA::icon('refresh') . "\n" . UsniAdaptor::t('application', 'Reload'), 
                              UsniAdaptor::createUrl('/payment/default/reload'), 
                              ["id" => "action-toolbar-reload", "class" => "btn btn-default"]
                            );
            return Html::tag('div', $link, ['class' => "btn-group"]);
        }
        return null;
    }
}