<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\db;

use usni\library\db\DataManager;
use taxes\models\ProductTaxClass;
use usni\UsniAdaptor;
/**
 * Loads default data related to product tax class.
 * 
 * @package taxes\db
 */
class ProductTaxClassDataManager extends DataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return ProductTaxClass::className();
    }

    /**
     * @inheritdoc
     */
    public function getDefaultDataSet()
    {
         return [
                    [
                        'name'          => UsniAdaptor::t('tax', 'taxable goods'),
                        'description'   => UsniAdaptor::t('tax', 'Applied to goods on which tax has to be applied')
                    ]
                ];
    }
}