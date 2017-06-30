<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace wishlist\business;

use wishlist\models\Wishlist;
use products\dao\ProductDAO;
use cart\models\Item;
/**
 * Implement business logic for wishlist
 *
 * @package wishlist\business
 */
class Manager extends \common\business\Manager
{
    /**
     * Prepare wishlist
     * @param Wishlist $wishList
     * @return array
     */
    public function prepareWishlist($wishList)
    {
        $products   = [];
        if($wishList->itemsList != null)
        {
            $idListArray = [];
            foreach($wishList->itemsList as $productId)
            {
                $idListArray[] = "'" . $productId . "'"; 
            }
            $idList     = implode(',', $idListArray);
            $records    = ProductDAO::getProducts($idList, $this->language);
            foreach($records as $record)
            {
                $item = new Item();
                $item->setProductId($record['id']);
                $item->setName($record['name']);
                $item->setModel($record['model']);
                $item->setPrice($record['price']);
                $item->setThumbnail($record['image']);
                $item->setStockStatus($record['stock_status']);
                $products[] = $item;
            }
        }
        return $products;
    }
}
