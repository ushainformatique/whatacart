<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;
    
use usni\library\components\UiSecuredActiveRecord;
/**
 * ZoneTranslated class file
 * @package taxes\models;
 */
class ZoneTranslated extends UiSecuredActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getZone()
    {
        return $this->hasOne(Zone::className(), ['id' => 'owner_id']);
    }
}
?>