<?php
/* @var $formDTO \usni\library\modules\install\dto\InstallFormDTO */
/* @var $this \usni\library\web\AdminView */
?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo $this->title;?></h3>
    </div>
</div>
<?php echo $this->render('/_settingsform', ['formDTO' => $formDTO]);
