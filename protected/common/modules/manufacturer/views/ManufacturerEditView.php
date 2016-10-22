<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\UsniAdaptor;
use usni\library\utils\ButtonsUtil;
use usni\library\components\UiActiveForm;
use usni\library\components\UiHtml;
use usni\library\utils\StatusUtil;
use usni\library\utils\AdminUtil;
/**
 * ManufacturerEditView class file.
 *
 * @package common\modules\manufacturer\views
 */
class ManufacturerEditView extends UiBootstrapEditView
{

    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'      => ['type' => 'text'],
                        //Later Height and width would be picked up from store's image configuration.
                        AdminUtil::renderThumbnail($this->model, 'image'),
                        'image'     => ['type' => UiActiveForm::INPUT_FILE],
                        'status'    => UiHtml::getFormSelectFieldOptionsWithNoSearch(StatusUtil::getDropdown()),
                    ];
        $metadata = [
                        'elements'  => $elements,
                        'buttons'   => ButtonsUtil::getDefaultButtonsMetadata('manufacturer/default/manage')
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    public function isMultiPartFormData()
    {
        return true;
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        parent::registerScripts();
        if($this->model->id != null)
        {
            $url = UsniAdaptor::createUrl('manufacturer/default/delete-image');
            AdminUtil::registerDeleteImageScripts($this->model->id, $url, get_class($this->model), $this->getView());
        }
    }
}