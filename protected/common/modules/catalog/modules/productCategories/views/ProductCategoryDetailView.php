<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\views;

use common\modules\catalog\views\BaseDetailView;
use usni\library\utils\FileUploadUtil;
use usni\library\utils\StatusUtil;
use productCategories\utils\ProductCategoryUtil;
use productCategories\views\ProductCategoryBrowseModelView;
use common\modules\dataCategories\utils\DataCategoryUtil;
use productCategories\models\ProductCategory;
/**
 * Product category detail view.
 * 
 * @package productCategories\views
 */
class ProductCategoryDetailView extends BaseDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                        'name',
                        'alias',
                        [
                            'attribute'  => 'image',
                            'value'      => FileUploadUtil::getThumbnailImage($this->model, 'image'),
                            'format'     => 'raw'
                        ],
                        'level',
                        [
                            'attribute'  => 'description', 
                            'format'     => 'html'
                        ],
                        [
                            'attribute'  => 'parent_id',
                            'value'      => ProductCategory::getParentName($this->model, null, null, null)   
                        ],
                        [
                            'attribute'  => 'status', 
                            'value'      => StatusUtil::renderLabel($this->model), 'format' => 'raw'
                        ],
                        [
                            'attribute'  =>  'displayintopmenu',
                            'value'      => ProductCategoryUtil::getDisplayInTopMenu($this->model->displayintopmenu)
                        ],
                        [
                            'attribute'  => 'data_category_id',
                            'value'      => $this->getDataCategory()
                        ],
                        'metakeywords',
                        'metadescription',
                        'code'
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
     * @inheritdoc
     */
    protected static function resolveBrowseModelViewClassName()
    {
        return ProductCategoryBrowseModelView::className();
    }
    
    /**
     * Get data category.
     * @return string
     */
    protected function getDataCategory()
    {
        $dataCategory = DataCategoryUtil::getDataCategoryById($this->model->data_category_id);
        return $dataCategory['name'];
    }
}
?>