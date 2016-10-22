<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\models;

use usni\library\components\TranslatableActiveRecord;
use usni\UsniAdaptor;
use products\models\Product;
use usni\library\modules\users\models\User;
use usni\library\modules\users\utils\UserUtil;

/**
 * This is the model class for table "product_reviewss".
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
                  [['name', 'review', 'product_id', 'status'], 'required'],
                  [['name', 'review', 'product_id', 'status'], 'safe'],
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario = parent::scenarios();
        $scenario['create']  = $scenario['update']    = ['name', 'review', 'product_id', 'status'];
        $scenario['approve'] = $scenario['unapprove'] = $scenario['delete']      =  $scenario['spam'] = $scenario['removespam'] = 
        $scenario['bulkdelete'] = ['status'];
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
    
    /**
     * @inheritdoc
     */
    public function updateCreatedDateTimeFields($event)
    {
        $isInstalled = UsniAdaptor::app()->isInstalled();
        if($this->shouldAddCreatedAndModifiedFields())
        {
            $this->addCreatedFields($event);
            $userModel  = UsniAdaptor::app()->user->getUserModel();
            if($isInstalled)
            {   
                if($userModel != null)
                {
                    $this->created_by = $userModel['id'];
                }
                else
                {
                    $this->created_by = 0;
                }
            }
            else
            {
                if(!$isInstalled)
                {
                   $userModel = UserUtil::getUserById(User::SUPER_USER_ID);
                }
                $this->created_by = $userModel['id'];
            }
            if($this->created_datetime == null || $this->created_datetime == '0000-00-00 00:00:00')
            {
                $this->created_datetime = date('Y-m-d H:i:s');
            }
        }
    }
}