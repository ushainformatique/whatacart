<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

use usni\library\components\UiHtml;
use usni\UsniAdaptor;
use common\utils\ApplicationUtil;

$favIcon = ApplicationUtil::getFavIcon($this->theme->baseUrl);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="language" content="<?php echo UsniAdaptor::app()->language;?>" />
        <link rel="icon" type="image/ico" href="<?php echo $favIcon; ?>" />
        <title><?php echo UiHtml::encode($this->title); ?></title>
        <?php echo UiHtml::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>

    <body>
        <?php $this->beginBody() ?>
        <?php echo $content;?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage();