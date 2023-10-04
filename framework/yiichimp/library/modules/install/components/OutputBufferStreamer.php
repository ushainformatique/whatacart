<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\install\components;

use yii\base\Component;
/**
 * OutputBufferStreamer class file.
 * 
 * The implementation of this class referenced MessageStreamer from http://zurmo.com.
 * @package usni\library\modules\install\components
 */
class OutputBufferStreamer extends Component
{
    /**
     * Pad space.
     * @var int
     */
    private $_padSpace = 4096;
    /**
     * Message template.
     * @var string
     */
    private $_template = '{message}';
    /**
     * Progress bar template.
     * @var string
     */
    private $_progressBarTemplate = '{message}';

    /**
     * Class constructor.
     * @return void
     */
    public function __construct($template = null, $progressBarTemplate = null, $padSpace = 4096)
    {
        if($template != null)
        {
            $this->_template = $template;
        }
        if($progressBarTemplate != null)
        {
            $this->_progressBarTemplate = $progressBarTemplate;
        }
        $this->_padSpace = $padSpace;
    }

    /**
     * Add the message.
     * @param string $message
     */
    public function add($message)
    {
        echo strtr($this->template, array('{message}' => $message));
        echo str_pad(' ', $this->_padSpace);
        flush();
    }

    /**
     * Adds progress message.
     * @param string $message
     */
    public function addProgressMessage($message)
    {
        echo strtr($this->_progressBarTemplate, array('{message}' => $message));
        flush();
    }

    /**
     * Sets the template.
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->_template = $template;
    }
    
    /**
     * Get template
     * @return string
     */
    public function getTemplate()
    {
        return $this->_template;
    }
}