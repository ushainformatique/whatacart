<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\library\db\ActiveRecord;
/**
 * CustomerDownloadMapping active record.
 * 
 * @package products\models
 */
class CustomerDownloadMapping extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['customer_id', 'download_id'],  'required'],
                    [['customer_id', 'download_id'],  'safe']
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario               = parent::scenarios();
        $scenario['create']     = $scenario['update'] = ['customer_id', 'download_id'];
        return $scenario;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [];
    }
    
    /**
     * Get product attribute mapping
     * @param int $productId
     * @param int $downloadId
     * @return array
     */
    public static function getMapping($productId, $downloadId)
    {
        return CustomerDownloadMapping::find()->where('customer_id = :pid AND download_id = :aid', [':pid' => $productId, ':aid' => $downloadId])->one();
    }
}