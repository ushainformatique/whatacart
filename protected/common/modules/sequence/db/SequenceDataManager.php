<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\sequence\db;

use usni\library\db\DataManager;
use common\modules\sequence\models\Sequence;
/**
 * Loads default data related to sequence.
 * 
 * @package common\modules\sequence\db
 */
class SequenceDataManager extends DataManager
{
    /**
     * @inheritdoc
     */
    public function getDefaultDataSet()
    {
        return [
                    [
                        'invoice_sequence_no'   => '0',
                        'customer_sequence_no'  => '9999',
                        'order_sequence_no'     => '0'
                    ]
               ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Sequence::className();
    }
}