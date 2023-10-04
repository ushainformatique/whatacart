<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\widgets;

use usni\library\utils\Html;
use usni\UsniAdaptor;

/**
 * FormButtons extends the rendering of preview button for notification template
 *
 * @package usni\library\modules\notification\widgets
 */
class FormButtons extends \usni\library\bootstrap\FormButtons
{
    /**
     * inheritdoc
     */
    public function renderSection($name)
    {
        if($name == '{preview}')
        {
            return $this->renderPreviewButton();
        }
        return parent::renderSection($name);
    }
    
    /**
     * Renders submit button
     * @return string
     */
    public function renderPreviewButton()
    {
        return Html::a(UsniAdaptor::t('application', 'Preview'), '#', 
                       ['class'     => 'btn btn-warning',
                        'id'        => 'preview-button',
                        'target'    => '_blank',]);
    }
}
