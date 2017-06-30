<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;
    
use usni\library\db\ActiveRecord;
/**
 * TaxRuleTranslated class file.
 * 
 * @package taxes\models;
 */
class TaxRuleTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getTaxRule()
    {
        return $this->hasOne(TaxRule::className(), ['id' => 'owner_id']);
    }
}