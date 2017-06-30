<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\models;

use usni\UsniAdaptor;
use yii\validators\FileValidator;
/**
 * StoreImage active record.
 * 
 * @package common\modules\stores\models
 */
class StoreImage extends \yii\base\Model
{
    /**
     * Upload logo Instance.
     * @var string
     */
    public $logoUploadInstance;
    /**
     * logo saved image.
     * @var string
     */
    public $logoSavedImage;
    /**
     * Upload icon Instance.
     * @var string
     */
    public $iconUploadInstance;
    /**
     * Upload icon Instance.
     * @var string
     */
    public $iconSavedImage;
    
    //Form variables
    public $store_logo;
    public $icon;
    public $category_image_width;
    public $category_image_height;
    public $product_list_image_width; 
    public $product_list_image_height;
    public $related_product_image_width; 
    public $related_product_image_height;
    public $compare_image_width; 
    public $compare_image_height;
    public $wishlist_image_width;
    public $wishlist_image_height; 
    public $cart_image_width;
    public $cart_image_height;
    public $store_image_width;
    public $store_image_height;
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['category_image_width', 'category_image_height', 'product_list_image_width', 'product_list_image_height',
                      'related_product_image_width', 
                      'related_product_image_height', 'compare_image_width', 'compare_image_height', 'wishlist_image_width', 'wishlist_image_height', 
                      'cart_image_width', 'cart_image_height', 'store_image_width', 'store_image_height'],   'required'],
                    [['category_image_width', 'category_image_height', 'product_list_image_width', 'product_list_image_height',
                      'related_product_image_width', 
                      'related_product_image_height', 'compare_image_width', 'compare_image_height', 'wishlist_image_width', 'wishlist_image_height', 
                      'cart_image_width', 'cart_image_height', 'store_image_width', 'store_image_height'],   'number', 'integerOnly' => true],
                    [['icon', 'iconUploadInstance'], 'image', 'skipOnEmpty' => true, 'extensions' => 'ico', 'checkExtensionByMimeType' => false],
                    [['icon', 'iconUploadInstance'], FileValidator::className(), 'minSize' => 1150, 'maxSize' => 155648],
                    [['store_logo', 'logoUploadInstance'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, gif, jpeg'],
                    [['store_logo', 'icon', 'category_image_width', 'category_image_height', 'product_list_image_width', 
                      'product_list_image_height', 'related_product_image_width', 
                      'related_product_image_height', 'compare_image_width', 'compare_image_height', 'wishlist_image_width', 'wishlist_image_height', 
                      'cart_image_width', 'cart_image_height', 'store_image_width', 'store_image_height'],   'safe'],
               ];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario = parent::scenarios();
        $scenario['create'] = $scenario['update'] = ['store_logo', 'icon', 'category_image_width', 'category_image_height', 
        'product_list_image_width', 'product_list_image_height', 
        'related_product_image_width', 'related_product_image_height', 'compare_image_width', 'compare_image_height', 'wishlist_image_width', 
        'wishlist_image_height', 'cart_image_width', 'cart_image_height', 'store_image_width', 'store_image_height'];
        return $scenario;
    }
    
    /**
     * @inheritdoc
     */
	public function attributeLabels()
	{
		return [
                        'store_logo'                        => UsniAdaptor::t('stores','Store Logo'),
                        'icon'                              => UsniAdaptor::t('stores', 'Icon'),
                        'category_image_width'              => UsniAdaptor::t('stores', 'Category Image Width'),
                        'category_image_height'             => UsniAdaptor::t('stores', 'Category Image Height'),
                        'product_list_image_width'          => UsniAdaptor::t('stores', 'Product List Image Width'),
                        'product_list_image_height'         => UsniAdaptor::t('stores', 'Product List Image Height'),
                        'related_product_image_width'       => UsniAdaptor::t('stores', 'Related Product Image Width'),
                        'related_product_image_height'      => UsniAdaptor::t('stores', 'Related Product Image Height'),
                        'compare_image_width'               => UsniAdaptor::t('stores', 'Compare Image Width'),
                        'compare_image_height'              => UsniAdaptor::t('stores', 'Compare Image Height'),
                        'wishlist_image_width'              => UsniAdaptor::t('stores', 'Wishlist Image Width'),
                        'wishlist_image_height'             => UsniAdaptor::t('stores', 'Wishlist Image Height'),
                        'cart_image_width'                  => UsniAdaptor::t('stores', 'Cart Image Width'),
                        'cart_image_height'                 => UsniAdaptor::t('stores', 'Cart Image Height'),
                        'store_image_width'                 => UsniAdaptor::t('stores', 'Store Image Width'),
                        'store_image_height'                => UsniAdaptor::t('stores', 'Store Image Height')
                  ];
	}
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('application', 'Image');
    }
}