<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\widgets;

use kartik\rating\StarRating;
use usni\UsniAdaptor;
/**
 * InputRatingSubView class file
 *
 * @package products\widgets
 */
class InputRatingSubView extends \yii\bootstrap\Widget
{
    /**
     * @var array 
     */
    public $product;
    
    /**
     * @var \products\web\ProductView 
     */
    public $view;


    /**
     * @inheritdoc
     */
    public function run()
    {
        $step      = 0.1;
        $rating    = $this->product['rating'];
        if($rating != null)
        {
            $readonly       = true;
        }
        else
        {
            $readonly       = false;
        }
        $input  = StarRating::widget([
                'view' => $this->view,
                'id'   => 'input_rating_' . $this->product['id'],
                'name' => 'input_rating_' . $this->product['id'],
                'value' => $this->product['rating'],
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
        $this->registerScripts();
        $template = $this->getTemplate();
        return str_replace(['{##label##}', '{##input##}'], [$this->getLabel(), $input], $template);
    }
    
    /**
     * Get label before the rating
     * @return string
     */
    protected function getLabel()
    {
        if($this->product['rating'] == 0)
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
        $id         = 'input_rating_' . $this->product['id'];
        $productId  = $this->product['id'];
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
        $this->view->registerJs($js);
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
                        <label for="input_rating_' . $this->product['id']  . '" class="control-label">{##label##}</label>
                      </td>
                      <td>
                        {##input##}
                      </td>
                    </tr>
                  </table>';
    }
}