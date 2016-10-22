<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace console\components;

/**
 * LanguageManager class file.
 * @package console\components
 */
class LanguageManager extends \usni\library\components\LanguageManager
{
    /**
     * @inheritdoc
     */
    public function getContentLanguage()
    {
        return 'en-US';
    }
}
?>