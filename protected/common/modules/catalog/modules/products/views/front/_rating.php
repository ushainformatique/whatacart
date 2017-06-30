<?php
use kartik\rating\StarRating;

$step   = 0.1;
$input  = StarRating::widget([
        'view' => $this, //Set the view to \products\web\ProductView
        'id'   => 'rating_' . $product['id'],
        'name' => 'rating_' . $product['id'],
        'value' => $product['overallRating'],
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
?>
<table>
    <tr>
      <td>
        <?php echo $input;?>
      </td>
    </tr>
</table>

