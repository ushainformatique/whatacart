<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\widgets;

use products\behaviors\PriceBehavior;
use usni\library\utils\Html;
use usni\UsniAdaptor;
/**
 * Renders price for the product
 *
 * @package products\widgets
 */
class PriceWidget extends \yii\bootstrap\Widget
{
    /**
     * Product final price excluding tax
     * @var float 
     */
    public $priceExcludingTax;
    
    /**
     * Tax for the product
     * @var float 
     */
    public $tax;
    
    /**
     * Default price for the product
     * @var float 
     */
    public $defaultPrice;
    
    /**
     * Is detail page
     * @var boolean 
     */
    public $isDetail = false;
    
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
     * inheritdoc
     */
    public function run()
    {
        $currencyCode = UsniAdaptor::app()->currencyManager->selectedCurrency;
        $price = $this->getFormattedPrice($this->priceExcludingTax + $this->tax, $currencyCode);
        if($this->isDetail)
        {
            $str  = Html::tag('strong', Html::tag('span', $price, ['class' => 'price-new']));
        }
        else
        {
            $str  = Html::tag('span', $price, ['class' => 'price-new']);
        }
        if($this->defaultPrice == $this->priceExcludingTax)
        {
            return $str;
        }
        else
        {
            $str      .= ' ' . Html::tag('span', $this->getFormattedPrice($this->defaultPrice + $this->tax, $currencyCode), ['class' => 'price-old']);
            if($this->tax > 0)
            {
                $str  .= '<br/>' . Html::tag('span', UsniAdaptor::t('products', 'Ex. Tax') . ': ' . $this->getFormattedPrice($this->priceExcludingTax, $currencyCode), ['class' => 'price-tax']);
            }
            return $str;
        }
    }
}
