<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\models;
    
use usni\library\db\ActiveRecord;

/**
 * PageTranslated class file
 * @package common\modules\cms\models
 */
class PageTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'owner_id']);
    }
}
?>