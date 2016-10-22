<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\views;

use usni\library\components\UiGridView;
use usni\UsniAdaptor;
use usni\library\modules\auth\managers\AuthManager;
use yii\data\ActiveDataProvider;
use usni\library\widgets\UiStatusDataColumn;
use products\components\ProductNameDataColumn;
use products\models\ProductCategoryMapping;
/**
 * LatestProductGridView class file.
 *
 * @package products\views
 */
class LatestProductGridView extends UiGridView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                        [
                            'attribute' => 'name',
                            'class'     => ProductNameDataColumn::className()
                        ],
                        'model',
                        [
                            'attribute'     => 'status',
                            'class'         => UiStatusDataColumn::className(),
                        ],
                   ];
        return $columns;
    }

    /**
     * @inheritdoc
     */
    protected function getTitle()
    {
        return UsniAdaptor::t('products', 'Latest Products');
    }
    
    /**
     * @inheritdoc
     */
    protected function getDataProvider()
    {
        $user           = UsniAdaptor::app()->user->getUserModel();
        $currentStore   = UsniAdaptor::app()->storeManager->getCurrentStore();
        $language       = UsniAdaptor::app()->languageManager->getDisplayLanguage();
        $productTable   = UsniAdaptor::tablePrefix() . 'product';
        $trProductTable = UsniAdaptor::tablePrefix() . 'product_translated';
        $mappingTable   = ProductCategoryMapping::tableName();
        $query          = (new \yii\db\Query());
        $query->select('tp.*, tpt.name')
              ->from(["$mappingTable tpcm, $productTable tp, $trProductTable tpt"])
              ->where('tpcm.data_category_id = :dci AND tpcm.product_id = tp.id AND tp.id = tpt.owner_id AND tpt.language = :lang', 
                     [':dci' => $currentStore->data_category_id, ':lang' => $language])
              ->orderBy('tp.id DESC');
        if(!(AuthManager::isUserInAdministrativeGroup($user)
                    && AuthManager::isSuperUser($user)) && !AuthManager::checkAccess($user, 'user.viewother'))
        {
            $query->andFilterWhere(['tp.created_by' => $user->id]);
        }
        $query->groupBy('tp.id');
        $query->limit(5);
        $dataProvider = new ActiveDataProvider(['query' => $query]);
        $dataProvider->setPagination(false);
        return $dataProvider;
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
    protected function renderCheckboxColumn()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected function getLayout()
    {
        return "<div class='panel panel-default'><div class='panel-heading'>{caption}</div>\n{items}</div>";
    }
}
?>
