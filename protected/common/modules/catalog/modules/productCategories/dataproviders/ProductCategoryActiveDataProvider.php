<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace productCategories\dataproviders;

use usni\library\dataproviders\TreeTranslatedActiveDataProvider;
/**
 * ProductCategoryActiveDataProvider class file
 *
 * @package productCategories\dataproviders
 */
class ProductCategoryActiveDataProvider extends TreeTranslatedActiveDataProvider
{
    /**
     * @inheritdoc
     * Need to override as there would be translated columns in the query now
     */
    public function filterValue($model, $key, $value)
    {
        if($model[$key] == $value)
        {
            return true;
        }
        elseif(strpos($model[$key], $value) === false)
        {
            return false;
        }
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function cmp($a, $b)
    {
        $attribute = $this->compareAttribute;
        if($attribute != null)
        {
            if($this->compareDirection == SORT_ASC)
            {
                return strcmp($a[$attribute], $b[$attribute]);
            }
            if($this->compareDirection == SORT_DESC)
            {
                return strcmp($b[$attribute], $a[$attribute]);
            }
        }
        else
        {
            return 0;
        }
    }
}
