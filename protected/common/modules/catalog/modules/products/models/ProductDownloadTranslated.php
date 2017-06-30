<?php 
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;
    
use usni\library\db\ActiveRecord;
/**
 * ProductDownloadTranslated class file
 * 
 * @package products\models
 */
class ProductDownloadTranslated extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function getProductDownload()
    {
        return $this->hasOne(ProductDownload::className(), ['id' => 'owner_id']);
    }
}