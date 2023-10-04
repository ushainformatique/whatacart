<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\i18n;

/**
 * I18N class file.
 * 
 * @package usni\library\i18n
 */
class I18N extends \yii\i18n\I18N
{
    public function init()
    {
        parent::init();
        if (!isset($this->translations['applicationhint'])) 
        {
            $this->translations['applicationhint'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@approot/messages',
            ];
        }
        if (!isset($this->translations['applicationflash'])) 
        {
            $this->translations['applicationflash'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@approot/messages',
            ];
        }
        if (!isset($this->translations['application'])) 
        {
            $this->translations['application'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@approot/messages',
            ];
        }
    }
}
?>