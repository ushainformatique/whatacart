<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\notifications;

use products\models\Product;
use usni\library\components\UiEmailNotification;
use usni\library\modules\notification\models\Notification;
/**
 * ProductReviewEmailNotification class file.
 *
 * @package products\notifications
 */
class ProductReviewEmailNotification extends UiEmailNotification
{
    /**
     * Review Data
     * @var array
     */
    public $review;
    
    /**
     * @inheritdoc
     */
    public function getKey()
    {
        return Product::NOTIFY_PRODUCTREVIEW;
    }

    /**
     * @inheritdoc
     */
    public function getModuleName()
    {
        return 'products';
    }
    
    /**
     * @inheritdoc
     */
    public function getDeliveryPriority()
    {
        return Notification::PRIORITY_HIGH;
    }

    /**
     * @inheritdoc
     */
    protected function getTemplateData()
    {
        return [
                    '{{customername}}'      => $this->review['name'],
                    '{{productname}}'       => $this->review['product_name'],
                    '{{review}}'            => $this->review['review']
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getLayoutData($data)
    {
        return array('{{####content####}}' => $data['templateContent']);
    }
    
    /**
     * @inheritdoc
     */
    public function setSubject($subject)
    {
        $this->subject = str_replace('{{productName}}', $this->review['product_name'], $subject);
    }
}
?>