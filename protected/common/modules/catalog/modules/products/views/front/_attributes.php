<?php
if(!empty($data))
{
?>
    <div id="tab-specifications" class="tab-pane">
        <table class="table table-bordered">
<?php
    foreach($data as $attributeGroupId => $attributeGroupData)
    {
        foreach($attributeGroupData as $attributeGroupName => $attributesData)
        {
?>
            <thead>
                <tr>
                    <th colspan="2"><?php echo $attributeGroupName;?></th>
                </tr>
            </thead>
            <tbody>
             <?php
             foreach($attributesData as $attributeData)
             {
             ?>
                <tr>
                    <td><?php echo $attributeData['name'];?></td>
                    <td><?php echo $attributeData['attribute_value'];?></td>
                </tr>
             <?php
             }
             ?>
            </tbody>
<?php
        }
    }
    ?>
            </table>
    </div>
<?php
}
?>