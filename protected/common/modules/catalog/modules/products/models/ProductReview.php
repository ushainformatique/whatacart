<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\models;

use usni\library\db\TranslatableActiveRecord;
use usni\UsniAdaptor;
use products\models\Product;

/**
 * This is the model class for table "product_reviews".
 */
class ProductReview extends TranslatableActiveRecord
{
    /**
     * Constant for comment status pending
     */
    const STATUS_PENDING    = 1;

    /**
     * Constant for comment status approved
     */
    const STATUS_APPROVED   = 2;

    /**
     * Constant for comment status spam
     */
    const STATUS_SPAM   = 3;

    /**
     * Constant for comment status deleted
     */
    const STATUS_DELETED   = 0;
    
    /**
     * New review posted event
     */
    const EVENT_NEW_REVIEW_POSTED = 'newReviewPosted';
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                  [['name', 'review', 'product_id', 'status', 'email'], 'required'],
                  ['email', 'email'],
                  [['name', 'review', 'product_id', 'status', 'email'], 'safe'],
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario = parent::scenarios();
        $scenario['create']  = $scenario['update']    = ['name', 'review', 'product_id', 'status', 'email'];
        $scenario['approve'] = $scenario['unapprove'] = $scenario['delete']      =  $scenario['spam'] = $scenario['removespam'] = 
        $scenario['bulkdelete'] = $scenario['undo'] = ['status'];
        return $scenario;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'name'             => UsniAdaptor::t('application', 'Name'),
                    'review'           => UsniAdaptor::t('products', 'Review'),
                    'email'            => UsniAdaptor::t('users', 'Email')
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
                    'name'             => UsniAdaptor::t('application', 'Enter your name'),
                    'review'           => UsniAdaptor::t('products', 'Max characters allowed are 200'), 
               ];
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('products', 'Review') : UsniAdaptor::t('products', 'Reviews');
    }
    
    /**
     * @inheritdoc
     */
    public static function getTranslatableAttributes()
    {
       return ['review']; 
    }
    
    /**
     * Get product.
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
       return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}