<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\dto;

/**
 * Data transfer object for notification template grid view.
 *
 * @package usni\library\modules\notification\dto
 */
class TemplateGridViewDTO extends \usni\library\dto\GridViewDTO
{
    /**
     * Layout options
     * @var array 
     */
    private $_layoutOptions;
    
    public function getLayoutOptions()
    {
        return $this->_layoutOptions;
    }

    public function setLayoutOptions($layoutOptions)
    {
        $this->_layoutOptions = $layoutOptions;
    }
}
