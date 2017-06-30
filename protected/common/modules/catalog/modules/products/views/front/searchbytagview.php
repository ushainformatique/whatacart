<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;

/* @var $listViewDTO \products\dto\TagListViewDTO */
/* @var $this \frontend\web\View */

$this->params['tagList'] = $listViewDTO->getTagList();
$this->leftnavView  = '/front/_sidebartagsearch';

$title              = UsniAdaptor::t('application', 'Search Results');
$this->title        = $this->params['breadcrumbs'][] = $title;
?>
<h2><?php echo $title . ' - ' . $listViewDTO->getSearchModel()->tag?></h2>
<?php
echo $this->render('//common/_searchresults', ['listViewDTO' => $listViewDTO]);



