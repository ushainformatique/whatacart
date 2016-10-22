<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\views;

use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\components\UiHtml;
use usni\library\utils\ButtonsUtil;
use common\modules\cms\utils\DropdownUtil;
use usni\UsniAdaptor;
use usni\library\components\UiActiveForm;
use marqu3s\summernote\Summernote;
use usni\library\widgets\forms\NameWithAliasFormField;
use usni\library\modules\install\components\InstallManager;
use marqu3s\summernote\SummernoteAsset;
use yii\web\View;
/**
 * PageEditView class file
 * @package common\modules\cms\views
 */
class PageEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        if($this->model->getIsNewRecord())
        {
            $this->model->created_by = UsniAdaptor::app()->user->getUserModel()->id;
        }
        $elements = [
                        'name'              => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => NameWithAliasFormField::className()],
                        'alias'             => ['type' => 'text'],
                        'parent_id'         => UiHtml::getFormSelectFieldOptions($this->model->getMultiLevelSelectOptions('name', 0, '-', true, $this->shouldRenderOwnerCreatedModels())),
                        'menuitem'          => ['type' => 'text'],
                        'summary'           => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => Summernote::className()],
                        'content'           => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => Summernote::className()],
                        'theme'             => UiHtml::getFormSelectFieldOptions(InstallManager::getAvailableThemes()),
                        '<hr/>',
                        'metakeywords'      => ['type' => 'textarea'],
                        'metadescription'   => ['type' => 'textarea'],
                        'status'            => UiHtml::getFormSelectFieldOptionsWithNoSearch(DropdownUtil::getStatusSelectOptions()),
                        'custom_url'        => ['type' => 'text'],
                    ];

        $metadata = [
                        'elements'  => $elements,
                        'buttons'   => self::getDefaultButtonsMetadata('cms/page/manage')
                    ];
        return $metadata;
    }

    /**
     * Get default buttons metadata.
     * @param string $cancelUrl Create Url.
     * @return array
     */
    public static function getDefaultButtonsMetadata($cancelUrl, $buttonId = 'savebutton')
    {
        return [
                    'save'   => ButtonsUtil::getSubmitButton(UsniAdaptor::t('application', 'Save')),
                    'cancel' => ButtonsUtil::getCancelLinkElementData($cancelUrl)
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        parent::registerScripts();
        $this->getView()->registerJsFile('@web/js/summernote-ext-plugin.js', ['depends' => [SummernoteAsset::className()]]);
        $this->getView()->registerJs("initBlock('page-content');", View::POS_END);
    }
}
?>