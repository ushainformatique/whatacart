<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\views;

use usni\library\components\UiHtml;
use common\modules\stores\utils\StoreUtil;
use usni\library\utils\StatusUtil;
use usni\library\utils\ButtonsUtil;
use common\modules\dataCategories\models\DataCategory;
use usni\library\components\UiActiveForm;
use marqu3s\summernote\Summernote;
use usni\library\modules\users\utils\UserUtil;
use usni\library\modules\users\models\User;
use usni\library\modules\install\components\InstallManager;
/**
 * StoreEditSubView class file
 * @package common\modules\stores\views
 */
class StoreEditSubView extends \usni\library\views\MultiModelEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'name'              => ['type' => 'text'],
                        'data_category_id'  => UiHtml::getFormSelectFieldOptionsWithNoSearch(StoreUtil::getDataCategorySelectOptions(DataCategory::className())),
                        'status'            => UiHtml::getFormSelectFieldOptionsWithNoSearch(StatusUtil::getDropdown()),
                        'owner_id'          => UiHtml::getFormSelectFieldOptionsWithNoSearch(UserUtil::getDropdownDataBasedOnModel(User::className()), [], ['prompt' => UiHtml::getDefaultPrompt()]),
                        'metakeywords'      => ['type' => 'textarea'],
                        'metadescription'   => ['type' => 'textarea'],
                        'description'       => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => Summernote::className()],
                        'theme'             => UiHtml::getFormSelectFieldOptions(InstallManager::getAvailableThemes()),
                    ];
        $metadata = [
                        'elements'          => $elements,
                        'buttons'           => ButtonsUtil::getDefaultButtonsMetadata("stores/default/manage")
                    ];
        return $metadata;
    }
}
