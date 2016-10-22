<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views\front;

use products\models\Product;
use kartik\rating\StarRating;
use usni\UsniAdaptor;
use products\utils\ProductUtil;
/**
 * InputRatingSubView class file
 *
 * @package products\views\front
 */
class InputRatingSubView extends \usni\library\views\UiView
{
    /**
     * Product id
     * @var Product 
     */
    public $productId;
    
    /**
     * Value for the rating
     * @var int 
     */
    public $value;
    
    /**
     * @inheritdoc
     */
    protected function renderContent()
    {
        return $this->getContent();
    }
    
    /**
     * Get content
     * @return string
     */
    protected function getContent()
    {
        $step   = 0.1;
        $customer = UsniAdaptor::app()->user->getUserModel();
        $rating = ProductUtil::getCustomerRating($customer->id, $this->productId);
        if($rating != null)
        {
            $readonly       = true;
            $this->value    = $rating['rating'];
        }
        else
        {
            $readonly       = false;
            $this->value    = 0;
        }
        $input  = StarRating::widget([
                'id'   => 'input_rating_' . $this->productId,
                'name' => 'input_rating_' . $this->productId,
                'value' => $this->value,
                'pluginOptions' => [
                    'readonly'  => $readonly,
                    'showClear' => false,
                    'showCaption' => true,
                    'size' => 'xs',
                    'glyphicon' => false,
                    'ratingClass' => 'rating-fa',
                    'step'  => $step
                ],
            ]);
        $template = $this->getTemplate();
        return str_replace(['{##label##}', '{##input##}'], [$this->getLabel(), $input], $template);
    }

    /**
     * Get label before the rating
     * @return string
     */
    protected function getLabel()
    {
        if($this->value == 0)
        {
            return "<strong>" . UsniAdaptor::t('products', 'Rate this') . "</strong>";
        }
        else
        {
            return "<strong>" . UsniAdaptor::t('products', 'Your rating') . "</strong>";
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function registerScripts()
    {
        $id         = 'input_rating_' . $this->productId;
        $productId  = $this->productId;
        $url        = UsniAdaptor::createUrl('catalog/products/site/rating');
        $js         = "$('#$id').on('rating.change', function(event, value, caption) {
                            $.ajax({
                                    url: '{$url}',
                                    type: 'post',
                                    data: 'rating=' + value + '&productId=' + $productId,
                                    dataType: 'json',
                                    success: function(json) {

                                    }
                                });
                        })";
        $this->getView()->registerJs($js);
    }
    
    /**
     * Get template
     * @return string
     */
    protected function getTemplate()
    {
        return '<table>
                    <tr>
                      <td style="padding-right:10px">
                        <label for="input_rating_' . $this->productId  . '" class="control-label">{##label##}</label>
                      </td>
                      <td>
                        {##input##}
                      </td>
                    </tr>
                  </table>';
    }
}