<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\business\layout;

use usni\library\modules\notification\dao\NotificationDAO;
/**
 * Manager class for notification layout
 *
 * @package usni\library\modules\notification\business\layout
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return NotificationDAO::getLayouts($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        return NotificationDAO::getLayout($id, $this->language);
    }
}
