<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace cart\business;

use cart\dto\CheckoutDTO;
use common\modules\cms\models\PageTranslated;
/**
 * CheckoutManager implements the business logic for checkout for front end.
 *
 * @package cart\business
 */
class CheckoutManager extends \common\modules\order\business\AdminCheckoutManager
{
    /**
     * @inheritdoc
     * @param CheckoutDTO $checkoutDTO
     */
    public function processCheckout($checkoutDTO)
    {
        parent::processCheckout($checkoutDTO);
        $terms      = PageTranslated::find()->where('alias = :alias AND language = :lan', [':alias' => 'terms', ':lan' => $this->language])->asArray()->one();
        $checkoutDTO->setTerms($terms);
    }
}