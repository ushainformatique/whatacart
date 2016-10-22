<?php
namespace common\modules\order\models;

use usni\UsniAdaptor;
use yii\base\Model;
/**
 * AdminConfirmOrderEditForm class file
 *
 * @package common\modules\order\models
 */
class AdminConfirmOrderEditForm extends Model
{
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
        return array(
                        [['status'],  'required'],
                        [['status', 'comments'],  'safe']
                    );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'status' => UsniAdaptor::t('application', 'Status'),
                    'comments' => UsniAdaptor::t('application', 'Comments'),
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
                    'status' => UsniAdaptor::t('orderhint', 'Status for the order'),
                    'comments' => UsniAdaptor::t('orderhint', 'Comments for the order'),
                ];
    }
}