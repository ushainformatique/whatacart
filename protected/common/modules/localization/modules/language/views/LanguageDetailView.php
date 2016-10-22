<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\language\views;

use usni\library\views\UiDetailView;
use usni\library\utils\StatusUtil;
use usni\library\utils\FileUploadUtil;
use usni\UsniAdaptor;
/**
 * LanguageDetailView class file
 *
 * @package common\modules\localization\views
 */
class LanguageDetailView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                    'name',
                    'code',
                    'locale',
                    [
                        'attribute' => 'image',
                        'value'     => FileUploadUtil::getThumbnailImage($this->model, 'image'),
                        'format'    => 'raw'
                    ],
                    'sort_order',
                  [
                      'attribute' => 'status', 'value' => StatusUtil::renderLabel($this->model), 'format' => 'raw'
                  ]
               ];
    }

    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return $this->model->name;
    }
    
    /**
     * Gets delete button url.
     *
     * @return string
     */
    protected function getDeleteUrl()
    {
        return UsniAdaptor::createUrl('localization/' . $this->getModule() . '/' . $this->controller->id . '/delete', ['id' => $this->model->id]);
    }

    /**
     * Gets edit button url.
     *
     * @return string
     */
    protected function getEditUrl()
    {
        return UsniAdaptor::createUrl('localization/' . $this->getModule() . '/' . $this->controller->id . '/update', ['id' => $this->model->id]);
    }
}
?>