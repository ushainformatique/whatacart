<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use common\modules\cms\models\PageTranslated;
use usni\UsniAdaptor;

$language   = UsniAdaptor::app()->languageManager->getContentLanguage();
$terms      = PageTranslated::find()->where('alias = :alias AND language = :lan', [':alias' => 'terms', ':lan' => $language])->asArray()->one();
?>
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="previewLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <?php echo $terms['content'];?>
            </div>
        </div>
    </div>
</div>