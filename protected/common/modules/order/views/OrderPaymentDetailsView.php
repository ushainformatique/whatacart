<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\views;

use usni\library\views\UiDetailView;
use products\utils\ProductUtil;
use common\modules\payment\utils\PaymentUtil;
/**
 * OrderPaymentDetailsView class. Provide details about order payment. Used on OrderDetailView in admin and front
 *
 * @package common\modules\order\views
 */
class OrderPaymentDetailsView extends UiDetailView
{
    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        $columns = [
                    [
                        'attribute' => 'payment_method',
                        'value'     => PaymentUtil::getPaymentMethodName($this->model['payment_method'])
                    ],
                    [
                        'attribute' => 'total_including_tax',
                        'value'     => $this->getFormattedPrice('total_including_tax'),
                        'format'    => 'raw'
                    ],
                    [
                        'attribute' => 'tax',
                        'value'     => $this->getFormattedPrice('tax'),
                        'format'    => 'raw'
                    ],
                    'payment_type',
                    'comments'
                ];
        if($this->model['shipping_fee'] > 0)
        {
            $columns[] = [
                            'attribute' => 'shipping_fee',
                            'value'     => $this->getFormattedPrice('shipping_fee'),
                            'format'    => 'raw'
                       ];
        }
        return $columns;
    }

    /**
     * @inheritdoc
     */
    protected function shouldRenderTitle()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected static function shouldRenderCreatedAttributes()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    protected static function shouldRenderModifiedAttributes()
    {
        return false;
    }
    
    /**
     * Get formatted price.
     * @param string $attribute
     * @return mixed.
     */
    protected function getFormattedPrice($attribute)
    {
        $price = number_format($this->model[$attribute], 2, ".", "");
        return ProductUtil::getPriceWithSymbol($price, $this->model['currency_code']);
    }
    
    /**
     * @inheritdoc
     */
    protected function renderDetailModelBrowseView()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    protected function wrapView($content)
    {
        return $content;
    }
}
