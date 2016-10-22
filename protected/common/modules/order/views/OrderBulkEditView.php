<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views;

use usni\library\extensions\bootstrap\views\UiBootstrapBulkEditView;
use usni\library\components\UiHtml;
use usni\UsniAdaptor;
use usni\library\utils\DAOUtil;
use common\modules\localization\modules\orderstatus\models\OrderStatus;
/**
 * OrderBulkEditView class file
 * 
 * @package common\modules\order\views
 */
class OrderBulkEditView extends UiBootstrapBulkEditView
{
    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'status'    => UiHtml::getFormSelectFieldOptionsWithNoSearch(DAOUtil::getDropdownDataBasedOnModel(OrderStatus::className())),
                    ];
        $metadata = [
                        'elements'          => $elements,
                        'buttons'           => $this->getSubmitButton()
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('order', 'Order Bulk Edit');
    }
}
?>