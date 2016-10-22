<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\views;

use usni\library\components\UiActiveForm;
use marqu3s\summernote\Summernote;
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use usni\library\utils\DAOUtil;
use common\modules\stores\models\Store;
use newsletter\utils\NewsletterUtil;
use common\modules\marketing\views\SendMailEditView;
/**
 * NewsletterEditView class file.
 * 
 * @package common\modules\newsletter\views
 */
class NewsletterEditView extends SendMailEditView
{

    /**
     * @inheritdoc
     */
    public function getFormBuilderMetadata()
    {
        $elements = [
                        'store_id'      => UiHtml::getFormSelectFieldOptionsWithNoSearch(DAOUtil::getDropdownDataBasedOnModel(Store::className())),
                        'to'            => UiHtml::getFormSelectFieldOptions(NewsletterUtil::getToNewsletterDropdown()),
                        'subject'       => ['type' => 'text'],
                        'content'       => ['type' => UiActiveForm::INPUT_WIDGET, 'class' => Summernote::className()],
                    ];
        $metadata = [
                        'elements'  => $elements,
                        'buttons'   => self::getDefaultButtonsMetadata('marketing/newsletter/default/manage')
                    ];
        return $metadata;
    }
    
    /**
     * @inheritdoc
     */
    protected function renderTitle()
    {
        return UsniAdaptor::t('newsletter', 'Send Newsletter');
    }
}
?>