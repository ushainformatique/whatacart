<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use yii\base\Model;
use usni\UsniAdaptor;
use yii\data\Sort;
use products\models\ProductDownloadTranslated;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * MyDownloadSearch class file
 * This is the search class for model Order.
 *
 * @package common\modules\order\models
 */
class MyDownloadSearch extends ProductDownload 
{
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return ProductDownload::tableName();
    }
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'file', 'type', 'created_datetime'],       'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveTranslatedModelClassName()
    {
        return ProductDownloadTranslated::className();
    }
    
    /**
     * Search based on get params.
     *
     * @return ArrayRecordDataProvider
     */
    public function search()
    {
        $currentStoreId     = UsniAdaptor::app()->storeManager->selectedStoreId;
        $language           = UsniAdaptor::app()->languageManager->selectedLanguage;
        $completedStatus    = $this->getStatusId('Completed', $language);
        $query              = new \yii\db\Query();
        $tableName          = UsniAdaptor::tablePrefix() . 'order';
        $orderPrTable       = UsniAdaptor::tablePrefix() . 'order_product';
        $prDownloadTable    = UsniAdaptor::tablePrefix() . 'product_download';
        $prDownloadTrTable  = UsniAdaptor::tablePrefix() . 'product_download_translated';
        $prDownloadMapTable = UsniAdaptor::tablePrefix() . 'product_download_mapping';
        $query->select(["opd.*", "opdtr.name", "ot.id AS order_id", "opdm.download_option"])
              ->from(["$tableName ot"])
              ->innerJoin("$orderPrTable opr", "ot.id = opr.order_id")
              ->innerJoin("$prDownloadMapTable opdm", "opr.product_id = opdm.product_id")
              ->innerJoin("$prDownloadTable opd", "opdm.download_id = opd.id")
              ->innerJoin("$prDownloadTrTable opdtr", "opd.id = opdtr.owner_id AND opdtr.language = :lan")  
              ->where('ot.status = :status AND ot.store_id = :sid AND ot.customer_id = :cid', 
                     [':status' => $completedStatus, ':sid' => $currentStoreId, ':cid' => $this->getUserId(), 
                      ':lan' => $language]);
        
        $dataProvider   = new ArrayRecordDataProvider([
            'query' => $query,
            'key'   => 'id'
        ]);
        $sort = new Sort(['attributes' => ['name', 'type', 'file']]);
        $dataProvider->setSort($sort);
        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'opdtr.name', $this->name]);
        $query->andFilterWhere(['like', 'file', $this->file]);
        $query->andFilterWhere(['type' => $this->type]);
        return $dataProvider;
    }
}