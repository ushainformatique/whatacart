<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\language\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\components\UiHtml;
use usni\library\utils\StatusUtil;
use usni\library\utils\ButtonsUtil;
use usni\library\components\UiActiveForm;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
/**
 * LanguageEditView class file
 * 
 * @package common\modules\localization\views
 */
class LanguageEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements =    [
                            'name'              => ['type' => 'text'],
                            'code'              => ['type' => 'text'],
                            'locale'            => ['type' => 'text'],
                            //Later Height and width would be picked up from store's image configuration.
                            AdminUtil::renderThumbnail($this->model, 'image'),
                            'image'             => ['type' => UiActiveForm::INPUT_FILE],
                            'sort_order'        => ['type' => 'text'],
                            'status'            => UiHtml::getFormSelectFieldOptionsWithNoSearch(StatusUtil::getDropdown()),
                       ];
        if($this->model->scenario == 'update' && $this->model->code == 'en-US')
        {
            $elements['code']   = ['type' => 'hidden'];
            $elements['locale'] = ['type' => 'hidden'];
            $elements['status'] = ['type' => 'hidden'];
        }
        $metadata =    [
                            'elements'   => $elements,
                            'buttons'    => ButtonsUtil::getDefaultButtonsMetadata('localization/language/default/manage')
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
            $url = UsniAdaptor::createUrl('localization/language/default/delete-image');
            AdminUtil::registerDeleteImageScripts($this->model->id, $url, get_class($this->model), $this->getView());
        }
    }
}
?>