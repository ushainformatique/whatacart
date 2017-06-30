<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\models;

use usni\UsniAdaptor;
use products\behaviors\PriceBehavior;
/**
 * AdminConfirmOrderEditForm class file
 *
 * @package common\modules\order\models
 */
class AdminConfirmOrderEditForm extends \cart\models\ConfirmOrderForm
{
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            PriceBehavior::className()
        ];
    }
    
    /**
     * Status of order
     * @var boolean 
     */
    public $status;
    
    /**
     * Comments on confirmation. This would be stored in history.
     * @var string 
     */
    public $comments;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
                        [['status'],  'required'],
                        [['status', 'comments'],  'safe']
                    ));
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
                    'status'        => UsniAdaptor::t('application', 'Status'),
                    'comments'      => UsniAdaptor::t('application', 'Comments')
               ]);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
                    'status'        => UsniAdaptor::t('orderhint', 'Status for the order'),
                    'comments'      => UsniAdaptor::t('orderhint', 'Comments for the order')
                ]);
    }
}