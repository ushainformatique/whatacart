<h2><?php echo $title;?></h2>
<div class="row">
    <div class="col-sm-2">
        <?php echo $thumbnail;?>
    </div>
    <div class="col-sm-10">
        <p><?php echo $description;?></p>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-md-4">
        <?php echo $listOrGrid;?>
    </div>
    <?php echo $sortBy;?>
    <?php echo $showItemsPerPage;?>
</div>
<br/>
<?php echo $productListView;?>