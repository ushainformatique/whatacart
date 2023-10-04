<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace usni\library\modules\settings\widgets;

/**
 * Renders the thumbnail image with a delete link
 *
 * @package usni\library\modules\settings\widgets
 */
class Thumbnail extends \usni\library\widgets\Thumbnail
{
    /**
     * @inheritdoc
     */
    public function registerDeleteImageScript()
    {
        $script         = "$('.delete-image').click(function(){
                                                    $.ajax({
                                                            'type':'GET',
                                                            'url':'{$this->deleteUrl}',
                                                            'success':function(data)
                                                                      {
                                                                          $('.image-thumbnail').load(location.href + ' .image-thumbnail');
}
                                                          });
                                                 });";
        $this->getView()->registerJs($script);
    }
}
