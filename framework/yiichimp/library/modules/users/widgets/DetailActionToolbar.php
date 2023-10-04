<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\widgets;

use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\utils\ArrayUtil;
/**
 * Render action toolbar on top of users detail view.
 *
 * @package usni\library\widgets
 * 
 * @package usni\library\modules\users\widgets
 */
class DetailActionToolbar extends \usni\library\widgets\DetailActionToolbar
{
    /**
     * Change password url for the model
     * @var string 
     */
    public $changePasswordUrl; 
    
    /**
     * @inheritdoc
     */
    public function getListItems()
    {
        $items[]    = ['label' => FA::icon('lock') . "\n" . UsniAdaptor::t('application', 'Change Password'), 
                       'url' => $this->changePasswordUrl];
        return ArrayUtil::merge(parent::getListItems(), $items);
    }
}
