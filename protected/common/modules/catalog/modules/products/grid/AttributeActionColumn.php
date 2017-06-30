<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\grid;

use usni\UsniAdaptor;
use usni\library\utils\Html;
use usni\fontawesome\FA;
/**
 * AttributeActionColumn class file.
 * 
 * @package products\grid
 */
class AttributeActionColumn extends \usni\library\grid\ActionColumn
{
    /**
     * @inheritdoc
     */
    public function createUrl($action, $model, $key, $index)
    {
        $params = ['productId' => $model['product_id'], 'attributeId' => $model['attribute_id']];
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
            return Html::a($icon, $url, [
                        'title' => \Yii::t('yii', 'Delete'),
                        'data-pjax' => '0',
                    ]);
        }
        return null;
    }
}