<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use usni\UsniAdaptor;
use usni\library\db\TranslatableActiveRecord;
use usni\library\utils\FileUploadUtil;
/**
 * ProductImage active record.
 * 
 * @package products\models
 */
class ProductImage extends TranslatableActiveRecord
{
    /**
     * Upload File Instance.
     * @var string
     */
    public $uploadInstance;

    /**
     * Upload File Instance.
     * @var string
     */
    public $savedImage;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                   [['image'], 'required'],
                   [['product_id', 'image', 'caption'], 'safe'],
                   [['uploadInstance'], 'file', 'extensions' => 'jpg, png, gif', 'maxSize' => 300000]
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario = parent::scenarios();
        $scenario['create'] = $scenario['update'] = ['product_id', 'image', 'caption','uploadInstance'];
        return $scenario;
    }
    
    /**
     * Get product.
     * @return ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
                    'id'            => UsniAdaptor::t('application','Id'),
                    'product_id'    => UsniAdaptor::t('products', 'Product'),
                    'image'         => UsniAdaptor::t('application', 'Image'),
                    'caption'       => UsniAdaptor::t('products', 'Caption')
                  ];
        return parent::getTranslatedAttributeLabels($labels);
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('application', 'Image') : UsniAdaptor::t('application', 'Images');
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['caption'];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            $productThumbImageWidth     = UsniAdaptor::app()->storeManager->getImageSetting('product_list_image_width', 150);
            $productThumbImageHeight    = UsniAdaptor::app()->storeManager->getImageSetting('product_list_image_height', 150);
            FileUploadUtil::deleteImage($this, 'image', $productThumbImageWidth, $productThumbImageHeight);
            return true;
        }
        return false;
    }
}