<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\sequence\utils;

use common\modules\sequence\models\Sequence;
use usni\UsniAdaptor;
/**
 * SequenceUtil class file.
 * 
 * @package common\modules\sequence\utils
 */
class SequenceUtil
{
    /**
     * Update sequence number.
     * @return void
     */
    public static function updateSequenceNumber($columnName)
    {
        $sequence = Sequence::find()->one();
        UsniAdaptor::db()->createCommand()->update(Sequence::tableName(), [$columnName => intval($sequence->$columnName) + 1],
                                                        'id = :id', [':id' => $sequence->id])->execute();
    }
}