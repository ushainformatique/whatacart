<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\controllers;

use products\models\ProductAttributeGroup;
use common\modules\catalog\controllers\BaseController;
use usni\UsniAdaptor;
/**
 * AttributeGroupController class file.
 * @package products\controllers
 */
class AttributeGroupController extends BaseController
{
    use \usni\library\traits\EditViewTranslationTrait;
    
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return ProductAttributeGroup::className();
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'create'         => UsniAdaptor::t('application','Create') . ' ' . ProductAttributeGroup::getLabel(1),
                    'update'         => UsniAdaptor::t('application','Update') . ' ' . ProductAttributeGroup::getLabel(1),
                    'view'           => UsniAdaptor::t('application','View') . ' ' . ProductAttributeGroup::getLabel(1),
                    'manage'         => UsniAdaptor::t('application','Manage') . ' ' . ProductAttributeGroup::getLabel(2)
               ];
    }
}
