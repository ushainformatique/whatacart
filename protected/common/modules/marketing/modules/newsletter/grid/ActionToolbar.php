<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\grid;

use usni\UsniAdaptor;
use yii\helpers\Html;
use usni\fontawesome\FA;
/**
 * ActionToolbar class file.
 * 
 * @package newsletter\grid
 */
class ActionToolbar extends \usni\library\grid\ActionToolbar
{
    /**
     * Show send button.
     * @var boolean
     */
    public $showSend = true;
    
    /**
     * @var string permission to be checked for send button
     */
    public $sendPermission;
    
    /**
     * Layout for the action toolbar
     * @var string 
     */
    public $layout = "<div class='block'>
                        <div class='well text-center'>
                            <div class='action-toolbar btn-toolbar'>
                            {create}\n{perPage}\n{modalDetail}\n{bulkedit}\n{bulkdelete}\n{send}
                            </div>
                        </div>
                        <div class='toolbar-content'>
                            {bulkeditform}
                        </div>
                      </div>";
    
    /**
     * inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->sendPermission == null)
        {
            $this->sendPermission = $this->permissionPrefix . '.manage';
        }
    }
    
    /**
     * inheritdoc
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{send}':
                return $this->renderSendButton();
        }
        return parent::renderSection($name);
    }
    
    /**
     * Renders send button.
     * @return string
     */
    public function renderSendButton()
    {
        if($this->showSend && UsniAdaptor::app()->user->can($this->sendPermission))
        {   
            $button = Html::button(FA::icon('send') . "\n" . UsniAdaptor::t('application', 'Send'), 
                                                                                          ["id" => "action-toolbar-bulkedit",
                                                                                          "class" => "btn btn-default send-newsletter-btn"]);
            return Html::tag('div', $button, ['class' => "btn-group"]);
        }
        return null;
    }
}
