<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\views\front;

use products\models\ProductRating;
use products\models\Product;
use products\utils\ProductUtil;
use kartik\rating\StarRating;
/**
 * RatingSubView class file
 *
 * @package products\views\front
 */
class RatingSubView extends \usni\library\views\UiView
{
    /**
     * Product id
     * @var Product 
     */
    public $productId;
    
    /**
     * Rating count
     * @var int 
     */
    public $ratingCount;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->ratingCount == null)
        {
            $this->ratingCount = ProductRating::find()->where('product_id = :pId', [':pId' => $this->productId])->count();
        }
    }
    
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
        $overallRating = ProductUtil::getOverallRating($this->productId, $step);
        $input  = StarRating::widget([
                'id'   => 'rating_' . $this->productId,
                'name' => 'rating_' . $this->productId,
                'value' => $overallRating,
                'pluginOptions' => [
                    'showClear' => false,
                    'showCaption' => true,
                    'size' => 'xs',
                    'glyphicon' => false,
                    'ratingClass' => 'rating-fa',
                    'step'  => $step,
                    'readonly' => true
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
        return null;
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
                        <label for="rating_' . $this->productId  . '" class="control-label">{##label##}</label>
                      </td>
                      <td>
                        {##input##}
                      </td>
                    </tr>
                  </table>';
    }
}
