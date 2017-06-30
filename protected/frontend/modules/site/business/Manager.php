<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\modules\site\business;

use frontend\modules\site\models\ContactForm;
use usni\library\dto\FormDTO;
/**
 * Manager class file
 * 
 * @package frontend\modules\site\business
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * Process contact us.
     * @param FormDTO $formDTO
     */
    public function processContactUs($formDTO)
    {
        $postData   = $formDTO->getPostData();
        $model      = new ContactForm();
        if(!empty($postData))
        {
            $model->attributes = $postData;
            if ($model->validate())
            {
                if($model->sendMail())
                {
                    $formDTO->setIsTransactionSuccess(true);
                }
                else
                {
                    $formDTO->setIsTransactionSuccess(false);
                }
            }
        }
        $formDTO->setModel($model);
    }
}
