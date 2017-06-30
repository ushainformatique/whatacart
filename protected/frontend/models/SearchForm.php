<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\models;

use usni\UsniAdaptor;
/**
 * SearchForm class file.
 *
 * @package frontend\models
 */
class SearchForm extends \yii\base\Model
{
    /**
     * Store keyword during search.
     * @var string
     */
    public $keyword;
    
    /**
     * Category under which search has to be performed
     * @var mixed 
     */
    public $categoryId;
    
    /**
     * Manufacturer under which search has to be performed
     * @var mixed 
     */
    public $manufacturerId;
    
    /**
     * Tag under which search has to be performed
     * @var mixed 
     */
    public $tag;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['keyword', 'categoryId', 'manufacturerId', 'tag'], 'safe'],
                    [['keyword', 'categoryId', 'manufacturerId', 'tag'], 'filter', 'filter' => 'usni\library\utils\Html::encode']
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'keyword'       => UsniAdaptor::t('application', 'Keyword'),
                    'categoryId'    => UsniAdaptor::t('productCategories', 'Category'),
                    'manufacturerId'=> UsniAdaptor::t('manufacturer', 'Manufacturer'),
                    'tag'           => UsniAdaptor::t('products', 'Tag'),
               ];
    }
}