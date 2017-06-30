<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;

/* @var $listViewDTO \productCategories\dto\ProductCategoryListViewDTO */
/* @var $this \frontend\web\View */

$this->params['categoryList'] = $listViewDTO->getCategoryList();
$this->params['model']  = $listViewDTO->getSearchModel();
$this->leftnavView  = '//common/searchform';

$title              = UsniAdaptor::t('application', 'Search Results');
$this->title        = $this->params['breadcrumbs'][] = $title;
?>
<h2><?php echo $title?></h2>
<?php
echo $this->render('//common/_searchresults', ['listViewDTO' => $listViewDTO]);

