<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\sequence\traits;

use usni\UsniAdaptor;
use common\modules\sequence\models\Sequence;
/**
 * Implement common functions related to sequence
 * 
 * @package common\modules\sequence\behaviors
 */
trait SequenceTrait
{
    /**
     * Update sequence number.
     * @return void
     */
    public function updateSequenceNumber($columnName)
    {
        $sequence = Sequence::find()->asArray()->one();
        UsniAdaptor::db()->createCommand()->update(Sequence::tableName(), [$columnName => intval($sequence[$columnName]) + 1],
                                                        'id = :id', [':id' => $sequence['id']])->execute();
    }
    
    /**
     * Get unique id based on column.
     * @return string
     */
    public function getUniqueId($columnName)
    {
        $sequence       = Sequence::find()->asArray()->one();
        return intval($sequence[$columnName]) + 1;
    }
}