<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views\front;

use products\models\Product;
use yii\data\ActiveDataProvider;
use products\components\PriceDataColumn;
use usni\UsniAdaptor;
use products\utils\CompareProductsUtil;
use products\components\CompareActionColumn;
use common\utils\ApplicationUtil;
use usni\library\utils\FileUploadUtil;
use common\modules\stores\utils\StoreUtil;
use products\utils\ProductUtil;
use usni\library\components\Sort;
/**
 * CompareProductsListView class file
 * @package products\views
 */
class CompareProductsListView extends \usni\library\components\TranslatableGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return [
                    [
                        'attribute' => 'image',
                        'value'     => [$this, 'getImage'],
                        'format'    => 'raw',
                        'filter'    => false,
                        'enableSorting' => false
                    ],
                    'name',
                    'model',
                    'description',
                    [
                        'attribute'  => 'price',
                        'class'      => PriceDataColumn::className()
                    ],
                    [
                        'attribute' => 'manufacturer',
                        'value'     => 'productManufacturer.name'
                    ],
                    [
                        'attribute' => 'weight',
                        'value'     => [$this, 'getWeight'],
                    ],
                    [
                        'label'     => UsniAdaptor::t('products', 'Availabelity'),
                        'value'     => [$this, 'getAvailabelity'],
                    ],
                    [
                        'label'     => UsniAdaptor::t('products', 'Dimensions(L*W*H)'),
                        'value'     => [$this, 'getDimensions'],
                    ],
                    [
                        'label'     => UsniAdaptor::t('products', 'Product Attributes'),
                        'value'     => [$this, 'getProductAttributes'],
                        'format'    => 'raw',
                    ],
                    [
                        'label'     => UsniAdaptor::t('products', 'Rating'),
                        'value'     => [$this, 'getRating'],
                        'format'    => 'raw'
                    ],
                    [
                        'class'     => CompareActionColumn::className(),
                        'template'  => '{addToCart} {remove}'
                    ]
            ];
    }
    
    /**
     * Get rating.
     * @param mixed $model the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getRating($model, $key, $index, $column)
    {
        return CompareProductsUtil::getProductRating($model->id);
    }
    
    /**
     * @inheritdoc
     */
    protected function getDataProvider()
    {
        $compareProducts    = ApplicationUtil::getCompareProducts();
        $query              = Product::find();
        $tableName          = UsniAdaptor::tablePrefix() . 'product';
        if($compareProducts->itemsList != null)
        {
            $query      = $query->where(['in', "$tableName.id", $compareProducts->itemsList]);
            $query->innerJoinWith('translations');
        }
        else
        {
            $query      = $query->where("$tableName.id = :id", [':id' => -1]);
            $query->innerJoinWith('translations');
        }
        $this->dataProvider     = new ActiveDataProvider(['query' => $query, 'pagination' => false]);
        $sort                   = new Sort(['attributes' => ['name', 'model', 'price', 'manufacturer', 'weight']]);
        $this->dataProvider->setSort($sort);
        return $this->dataProvider;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderToolbar()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderDetailViewModal()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function getLayout()
    {
        return "{items}\n{summary}";
    }
    
    /**
     * @inheritdoc
     */
    protected function getGridContainerOptions()
    {
        return ['class' => 'compare-grid-container'];
    }
    
    /**
     * @inheritdoc
     */
    protected function getTableOptions()
    {
        return ['class' => 'table table-striped'];
    }
    
    /**
     * Render checkbox column
     * @return boolean
     */
    protected function renderCheckboxColumn()
    {
        return false;
    }
    
    /**
     * Gets product image.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     */
    public function getImage($data, $key, $index, $column)
    {
        $compareImageWidth          = StoreUtil::getImageSetting('compare_image_width', 50);
        $compareImageHeight         = StoreUtil::getImageSetting('compare_image_height', 50);
        return FileUploadUtil::getThumbnailImage($data, 'image', ['thumbWidth' => $compareImageWidth, 'thumbHeight' => $compareImageHeight]);
    }
    
    /**
     * Gets product availabelity.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     * getAvailabelity
     */
    public function getAvailabelity($data, $key, $index, $column)
    {
        $availability        = null;
        $displayStockSetting = StoreUtil::getSettingValue('display_stock');
        if ($displayStockSetting)
        {
            $availability = $data['quantity'];
        }
        else
        {
            $availability = $data['stock_status'] == 1 ? UsniAdaptor::t('products', 'In Stock') : UsniAdaptor::t('products', 'Out Of Stock');
        }
        return $availability;
    }
    
    /**
     * Gets product weight.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     * getAvailabelity
     */
    public function getWeight($data, $key, $index, $column)
    {
        $displayWeightSettings = StoreUtil::getSettingValue('display_weight');
        if ($displayWeightSettings)
        {
            return UsniAdaptor::app()->productWeightManager->getProductWeight($data['id']);
        }
    }
    
    /**
     * Gets product dimensions.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     * getAvailabelity
     */
    public function getDimensions($data, $key, $index, $column)
    {
        $displayDimensionSettings = StoreUtil::getSettingValue('display_dimensions');
        if ($displayDimensionSettings)
        {
            return UsniAdaptor::app()->productDimensionManager->getProductDimensions($data['id']);
        }
    }
    
    /**
     * Gets product attributes.
     * @param mixed $data the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data model among the models array returned by [[GridView::dataProvider]].
     * @param DataColumn $column
     * @return string
     * getAvailabelity
     */
    public function getProductAttributes($data, $key, $index, $column)
    {
        $productAttributes  = ProductUtil::getAttributes($data['id']);
        if(!empty($productAttributes))
        {
            $content            = null;
            foreach ($productAttributes as $productAttribute)
            {
                $content .= $productAttribute['name'] . ': ' . $productAttribute['attribute_value'] . '<br>';
            }
            return $content;
        }
        return UsniAdaptor::t('application', '(not set)');
    }
}
?>