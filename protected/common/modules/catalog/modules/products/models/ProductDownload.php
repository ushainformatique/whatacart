<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use usni\library\utils\FileUploadUtil;
use usni\library\utils\ArrayUtil;
use products\models\ProductDownloadTranslated;
use yii\db\Exception;
/**
 * This is the model class for table "product_download".
 * 
 * @package products\models
 */
class ProductDownload extends TranslatableActiveRecord
{
    /**
     * Upload File Instance.
     * @var string
     */
    public $uploadInstance;
    
    /**
     * Saved file in database.
     * @var string
     */
    public $savedFile;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $imageExtensions    = FileUploadUtil::getImageExtensions();
        $fileExtensions     = FileUploadUtil::getFileExtensions();
        $extensions         = ArrayUtil::merge($imageExtensions, $fileExtensions);
        $extensionStr       = implode(',', $extensions);
        return [
                    [['name', 'number_of_days', 'type', 'size'], 'required'],
                    ['name',  'string', 'max' => 128],
                    [['file'], 'required', 'on' => 'create'],
                    ['file',  'string', 'max' => 128],
                    [['number_of_days', 'allowed_downloads', 'size'], 'number', 'integerOnly' => true],
                    [['type'], 'string'],
                    [['number_of_days', 'allowed_downloads'], 'default', 'value' => 0],
                    [['file', 'uploadInstance'], 'file', 'skipOnEmpty' => true, 'extensions' => $extensionStr],
                    ['name', 'unique', 'targetClass' => ProductDownloadTranslated::className(), 'targetAttribute' => ['name', 'language'], 'on' => 'create'],
                    ['name', 'unique', 'targetClass' => ProductDownloadTranslated::className(), 'targetAttribute' => ['name', 'language'], 'filter' => ['!=', 'owner_id', $this->id], 'on' => 'update'],
                    [['name', 'file', 'type', 'size', 'number_of_days', 'allowed_downloads'], 'safe'],
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create']        = $scenarios['update'] = ['name', 'file', 'number_of_days', 'allowed_downloads', 'type', 'size'];
        $scenarios['deleteimage']   = ['file'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
                    'name'          => UsniAdaptor::t('application', 'Name'),
                    'file'          => UsniAdaptor::t('application', 'File'),
                    'number_of_days'=> UsniAdaptor::t('products', 'Number of Days'),
                    'allowed_downloads' => UsniAdaptor::t('products', 'Allowed Downloads'),
                    'type'              => UsniAdaptor::t('products', 'Download Type'),
                    'size'              => UsniAdaptor::t('products', 'Size'),
                    ];
        return parent::getTranslatedAttributeLabels($labels);
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('products', 'Download') : UsniAdaptor::t('products', 'Downloads');
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete())
        {
            $isAllowedToDelete = $this->checkIfAllowedToDelete();
            if(!$isAllowedToDelete)
            {
                throw new Exception('product is associated to the download.');
            }
            $config = [
                        'model'             => $this, 
                        'attribute'         => 'file', 
                        'uploadInstance'    => null, 
                        'savedFile'         => null
                      ];
            if($this->type == 'image')
            {
                $config['createThumbnail'] = true;
            }
            $fileManagerInstance = UsniAdaptor::app()->assetManager->getResourceManager($this->type, $config);
            $fileManagerInstance->delete();
            return true;
        }
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
        return ['name'];
    }
    
    /**
     * Check if allowed to delete
     * @return boolean
     */
    public function checkIfAllowedToDelete()
    {
        $count = ProductDownloadMapping::find()->where('download_id = :did', [':did' => $this->id])->count();
        if($count > 0)
        {
            return false;
        }
        return true;
    }
}