<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
/* @var $this \frontend\web\View */
/* @var $formDTO \cart\dto\CheckoutDTO */
use usni\UsniAdaptor;

$language   = UsniAdaptor::app()->languageManager->selectedLanguage;
$terms      = $formDTO->getTerms();
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