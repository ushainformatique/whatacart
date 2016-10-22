<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views;

use products\models\ProductAttributeMapping;
use usni\UsniAdaptor;
use products\models\ProductAttribute;
use products\components\AttributeActionColumn;
use products\models\ProductAttributeTranslated;
/**
 * AssignProductAttributeGridView class file
 *
 * @package products\views
 */
class AssignProductAttributeGridView extends \usni\library\components\UiGridView
{
    /**
     * Product id
     * @var int
     */
    public $productId;
    
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                       [
                           'attribute'  => 'name',
                       ],
                       [
                           'attribute'  => 'attribute_value'
                       ],
                       [
                           'class'      => AttributeActionColumn::className(),
                           'template'   => '{update} {delete}'
                       ]
                   ];
        return $columns;
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
    protected function resolveDataProviderQuery()
    {
        $prAttrMappingTableName = ProductAttributeMapping::tableName();
        $prAttributeTableName   = ProductAttribute::tableName();
        $prAttributeTrTableName = ProductAttributeTranslated::tableName();
        $query                  = new \yii\db\Query();
        $query->select('pam.*, pat.name')->from([$prAttrMappingTableName . ' pam', $prAttributeTableName . ' pa', $prAttributeTrTableName  . ' pat'])
            ->where('pam.product_id = :pid AND pam.attribute_id = pa.id AND pa.id = pat.owner_id AND pat.language = :lan')
            ->params([':pid' => $this->productId, ':lan' => 'en-US']);
        return $query;
    }
    
    /**
     * @inheritdoc
     */
    public function renderTitle()
    {
        return UsniAdaptor::t('application', 'Manage') . ' ' . ProductAttribute::getLabel(2);
    }
    
    /**
     * @inheritdoc
     */
    public function getPagination($metadata)
    {
        return false;
    }
}
?>