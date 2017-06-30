<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\widgets;
/**
 * ExtensionActionToolbar extends the base action toolbar for extension module
 *
 * @package common\modules\extension\widgets
 */
class ExtensionActionToolbar extends \usni\library\grid\ActionToolbar
{
    /**
     * Layout for the action toolbar
     * @var string 
     */
    public $layout = "<div class='block'>
                        <div class='well text-center'>
                            <div class='action-toolbar btn-toolbar'>
                            {perPage}\n
                            </div>
                        </div>
                      </div>";
}
