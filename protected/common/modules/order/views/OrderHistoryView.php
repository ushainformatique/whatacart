<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views;

use usni\library\views\UiView;
use common\modules\order\models\OrderHistory;
use usni\UsniAdaptor;
use common\modules\order\views\OrderHistoryEditView;
use yii\caching\DbDependency;
/**
 * OrderHistoryView class file.
 *
 * @package common\modules\order\views
 */
class OrderHistoryView extends UiView
{
    /**
     * Order model for which history has to be fetched
     * @var array 
     */
    public $model;
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        $historyEditViewContent = null;
        if($this->shouldRenderEditView())
        {
            $historyEditView = new OrderHistoryEditView(['model' => new OrderHistory()]);
            $historyEditViewContent = '<br/>' . $historyEditView->render();
        }
        return $this->getOrderDetails() . $historyEditViewContent;
    }
    
    /**
     * Get order details.
     */
    protected function getOrderDetails()
    {
        $filePath           = UsniAdaptor::getAlias('@common/modules/order/views/_orderHistory') . '.php';
        $language           = UsniAdaptor::app()->languageManager->getContentLanguage();
        $tableName          = UsniAdaptor::tablePrefix() . 'order_history';
        $trTableName        = UsniAdaptor::tablePrefix() . 'order_history_translated';
        $dependency         = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        $sql                = "SELECT oh.*, oht.comment
                                   FROM $tableName oh, $trTableName oht
                                   WHERE oh.order_id = :oid AND oh.id = oht.owner_id AND oht.language = :lan";
        $connection         = UsniAdaptor::app()->getDb();
        $records            = $connection->createCommand($sql, [':oid' => $this->model['id'], ':lan' => $language])->cache(0, $dependency)->queryAll();
        return $this->getView()->renderPhpFile($filePath, ['rows' => $records]);
    }
    
    /**
     * Should render edit view.
     * @return boolean
     */
    protected function shouldRenderEditView()
    {
        return true;
    }
}
?>