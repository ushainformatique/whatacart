<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\grid;

use usni\library\utils\Html;
use usni\fontawesome\FA;
use usni\UsniAdaptor;
/**
 * PreviewActionColumn class file.
 * 
 * @package usni\library\modules\notification\grid
 */
class PreviewActionColumn extends \usni\library\grid\ActionColumn
{
    /**
     * Initializes the default button rendering callbacks
     */
    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();
        if (!isset($this->buttons['preview']))
        {
            $this->buttons['preview'] = array($this, 'renderPreviewActionLink');;
        }
    }

    /**
     * Renders preview action link.
     * @param string $url
     * @param Model $model
     * @param string $key
     * @return string
     */
    public function renderPreviewActionLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'view'))
        {
            $label = UsniAdaptor::t('application', 'Preview');
            $icon  = "\n" . FA::icon('eye-slash');
            return Html::a($icon, '#', [
                                            'title'         => $label,
                                            'id'            => 'preview-button-' . $model['id'],
                                            'data-id'       => $model['id'],
                                            'class'         => 'grid-preview-link'
                                          ]);
        }
        return null;
    }
}