<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace cart\models;

use yii\base\Model;
use usni\UsniAdaptor;
/**
 * ConfirmOrderForm class file
 * 
 * @package cart\models
 */

class ConfirmOrderForm extends Model
{
    /**
     * Content during checkout.
     * @var string
     */
    public $content;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array(
                        [['content'],   'safe']
                        
                    );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'content'   => UsniAdaptor::t('application', 'Content'),
               ];
    }
}
