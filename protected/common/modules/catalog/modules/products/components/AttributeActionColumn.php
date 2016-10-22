<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\components;

use usni\library\extensions\bootstrap\widgets\UiActionColumn;
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use usni\fontawesome\FA;
use products\models\Product;
/**
 * AttributeActionColumn class file.
 * 
 * @package products\components
 */
class AttributeActionColumn extends UiActionColumn
{
    /**
     * @inheritdoc
     */
    public function createUrl($action, $model, $key, $index)
    {
        $params = ['product_id' => $model['product_id'], 'attribute_id' => $model['attribute_id']];
        if($action == 'update')
        {
            return UsniAdaptor::createUrl('/catalog/products/attribute/modify', $params);
        }
        elseif($action == 'delete')
        {
            return UsniAdaptor::createUrl('/catalog/products/attribute/remove', $params);
        }
    }
    
    /**
     * @inheritdoc
     */
    public function renderDeleteActionLink($url, $model, $key)
    {
        if($this->checkAccess($model, 'delete'))
        {
            $icon = FA::icon('trash-o');
            return UiHtml::a($icon, $url, [
                        'title' => \Yii::t('yii', 'Delete'),
                        'data-pjax' => '0',
                    ]);
        }
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function getModelClassName()
    {
        return UsniAdaptor::getObjectClassName(Product::className());
    }
}