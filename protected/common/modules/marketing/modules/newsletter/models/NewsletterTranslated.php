<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\models;
    
use usni\library\db\ActiveRecord;
/**
 * NewsletterTranslated class file.
 * 
 * @package newsletter\models
 */
class NewsletterTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getNewsletter()
    {
        return $this->hasOne(Newsletter::className(), ['id' => 'owner_id']);
    }
}