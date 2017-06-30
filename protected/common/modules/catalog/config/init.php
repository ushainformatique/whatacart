<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

return [
            'catalog' => [
                            'class' => 'common\modules\catalog\Module', 
                            'modules'       => [
                                                  'productCategories' => [
                                                                            'class' => 'productCategories\Module'
                                                                         ],
                                                  'products'          => [
                                                                            'class' => 'products\Module'
                                                                         ],
                                               ]
                          ]
      ];