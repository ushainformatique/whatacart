<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\views;

use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use usni\library\components\UiActiveForm;
use marqu3s\summernote\Summernote;
use usni\library\extensions\bootstrap\views\UiBootstrapEditView;
use usni\library\utils\DAOUtil;
use usni\library\utils\StatusUtil;
use usni\library\utils\ButtonsUtil;
use common\modules\dataCategories\models\DataCategory;
use usni\library\widgets\forms\NameWithAliasFormField;
use usni\library\utils\AdminUtil;
use productCategories\views\ProductCategoryBrowseModelView;
/**
 * Product category edit view.
 * @package productCategories\views
 */
class ProductCategoryEditView extends UiBootstrapEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements =  [
                          'data_category_id' => UiHtml::getFormSelectFieldOptionsWithNoSearch(DAOUtil::getDropdownDataBasedOnModel(DataCategory::className())),
                          'name'             => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => NameWithAliasFormField::className()],
                          'alias'            => ['type' => 'text'],
                          //Later Height and width would be picked up from store's image configuration.
                          AdminUtil::renderThumbnail($this->model, 'image'),
                          'image'            => ['type' => UiActiveForm::INPUT_FILE],
                          'description'      => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => Summernote::className()],
                          'parent_id'        => UiHtml::getFormSelectFieldOptions($this->model->getMultiLevelSelectOptions('name', 0, '-', true, $this->shouldRenderOwnerCreatedModels())),
                          'metakeywords'     => ['type' => 'textarea'],
                          'metadescription'  => ['type' => 'textarea'],
                          'status'           => UiHtml::getFormSelectFieldOptionsWithNoSearch(StatusUtil::getDropdown()),
                          'code'             => ['type' => 'text'],
                          'displayintopmenu' => ['type' => 'checkbox'],
                     ];
        $metadata =  [
                          'elements'      => $elements,
                          'buttons'       => ButtonsUtil::getDefaultButtonsMetadata('catalog/productCategories/default/manage')
                     ];
        return $metadata;
    }

    /**
     * If form data multipart.
     * @return boolean
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
            $url = UsniAdaptor::createUrl('catalog/productCategories/default/delete-image');
            AdminUtil::registerDeleteImageScripts($this->model->id, $url, get_class($this->model), $this->getView());
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function attributeOptions()
    {
        $horizontalCssClasses   = $this->getHorizontalCssClasses();
        $horizontalCssClasses['wrapper'] = '';
        $horizontalCssClasses['label']   = '';
        return array(
            'displayintopmenu' => array(
                    'labelOptions'  => array(),
                    'inputOptions'  => [],
                    'horizontalCheckboxTemplate' => '<div class="col-xs-12"><div class="checkbox checkbox-success"><label>{input}   ' . UsniAdaptor::t('productCategories', 'Display in top menu') . '</label></div></div>',
                    'horizontalCssClasses' => $horizontalCssClasses
            )
        );
    }
    
    /**
     * @inheritdoc
     */
    protected static function resolveBrowseModelViewClassName()
    {
        return ProductCategoryBrowseModelView::className();
    }
}
?>
