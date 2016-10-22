<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\models;
    
use usni\library\components\UiSecuredActiveRecord;
/**
 * NewsletterTranslated class file
 * @package newsletter\models
 */
class NewsletterTranslated extends UiSecuredActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getNewsletter()
    {
        return $this->hasOne(Newsletter::className(), ['id' => 'owner_id']);
    }
}
?>