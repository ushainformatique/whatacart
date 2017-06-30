<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\fontawesome\FA;
use usni\UsniAdaptor;
?>
<form id="navbarsearchformview" class="navbar-search" action="<?php echo UsniAdaptor::createUrl('site/default/search');?>" method="get">
    <div id="search" class="input-group">
        <input type="text" id="navbarsearchform-keyword" class="form-control input-lg" name="SearchForm[keyword]" placeholder="Search">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-default btn-lg" name="navsearch"><?php echo FA::icon('search');?></button>
        </span>
    </div>
</form>

