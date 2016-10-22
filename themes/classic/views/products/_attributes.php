<?php
use products\utils\ProductUtil;
$data = ProductUtil::getGroupedAttributes($product);
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
                <th>
                    <td colspan="2"><?php echo $attributeGroupName;?></td>
                </th>
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
        </table>
    </div>
<?php
        }
    }
}
?>