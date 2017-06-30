<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\behaviors;

use products\models\ProductReview;
use products\notifications\ProductReviewEmailNotification;
use products\dao\ReviewDAO;
use products\events\ReviewEvent;
/**
 * Handle the notification events related to products
 *
 * @package products\behaviors
 */
class NotificationService extends \usni\library\notifications\BaseNotificationService
{
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
                    ProductReview::EVENT_NEW_REVIEW_POSTED => [$this, 'sendReviewNotification'],
               ];
    }
    
    /**
     * Sends review email
     * @param ReviewEvent $event
     * @return boolean
     */
    public function sendReviewNotification($event)
    {
        $review                     = $event->productReview;   
        $reviewRecord               = ReviewDAO::getReview($review['id'], $review->language);             
        $emailNotification          = new ProductReviewEmailNotification(['review' => $reviewRecord]);
        $this->emailNotification    = $emailNotification;
        $this->to                   = $this->fromAddress;
        $this->fromName             = $reviewRecord['name'];
        $this->fromAddress          = $review['email'];
        $this->processSend();
    }
}
