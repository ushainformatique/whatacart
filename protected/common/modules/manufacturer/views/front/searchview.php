<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;

/* @var $listViewDTO \common\modules\manufacturer\dto\ManufacturerListViewDTO */
/* @var $this \frontend\web\View */

$this->params['manList'] = $listViewDTO->getManList();
$this->leftnavView  = '/front/_sidebar';

$manufacturer       = $listViewDTO->getManufacturer();
$title              = UsniAdaptor::t('application', 'Search Results');
$this->title        = $this->params['breadcrumbs'][] = $title;
?>
<h2><?php echo $title . '-' . $manufacturer['name']?></h2>
<?php
echo $this->render('//common/_searchresults', ['listViewDTO' => $listViewDTO]);