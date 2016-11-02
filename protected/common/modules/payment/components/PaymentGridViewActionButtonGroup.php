<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\components;

use usni\library\extensions\bootstrap\widgets\TranslatableGridViewActionButtonGroup;
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use usni\fontawesome\FA;
use usni\library\modules\auth\managers\AuthManager;
/**
 * PaymentGridViewActionButtonGroup class file.
 * 
 * @package common\modules\payment\components
 */
class PaymentGridViewActionButtonGroup extends TranslatableGridViewActionButtonGroup
{
    /**
     * @inheritdoc
     */
    protected function setButtons()
    {
        $buttons['settings']        = $this->renderSettingsFormLink();
        $buttons['reload']          = $this->renderReloadButton();
        $this->buttons = $buttons;
    }
    
    /**
     * Render reload button.
     * @return string.
     */
    protected function renderReloadButton()
    {
        $modelClass = strtolower(UsniAdaptor::getObjectClassName($this->model));
        if(AuthManager::checkAccess(UsniAdaptor::app()->user->getUserModel(), $modelClass . '.manage'))
        {
            $label           = FA::icon('refresh') . "\n" . UsniAdaptor::t('application', 'Reload');
            $reloadUrl       = UsniAdaptor::createUrl('/payment/default/reload');
            $content         = UiHtml::a($label, $reloadUrl, ['class' => 'btn btn-default reload-btn']);
            return $content;
        }
        return null;
    }
}
