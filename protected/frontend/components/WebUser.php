<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\components;

/**
 * WebUser class file.
 * @package frontend\components
 */
class WebUser extends \usni\library\components\UiWebUser
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ['login' => 'customer\components\LoginBehavior'];
    }
}
?>
