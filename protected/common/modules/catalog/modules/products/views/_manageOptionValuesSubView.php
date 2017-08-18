<?php
use usni\UsniAdaptor;
use usni\library\utils\Html;
?>
<table id="option-values-list" class="table table-striped table-bordered table-hover">
    <tbody>
        <?php
        if(!empty($assignedOptions))
        {
            foreach($assignedOptions as $assignedOption)
            {
                $isRequired     = $assignedOption['required'] ? UsniAdaptor::t('application', 'Yes') : UsniAdaptor::t('application', 'No');
                $optionLabel    = Html::tag('strong', UsniAdaptor::t('products', 'Option')) .  ': ' . $assignedOption['display_name'] . ' ' . 
                                    Html::tag('strong', UsniAdaptor::t('products', 'Required')) . ': ' . $isRequired;
            ?>
            <tr>
                <td colspan="5"><?php echo $optionLabel;?></td>
            </tr>
            <tr>
                <td><?php echo UsniAdaptor::t('products', 'Option Value');?></td>
                <td><?php echo UsniAdaptor::t('products', 'Quantity');?></td>
                <td><?php echo UsniAdaptor::t('products', 'Subtract Stock');?></td>
                <td><?php echo UsniAdaptor::t('products', 'Price');?></td>
                <td><?php echo UsniAdaptor::t('products', 'Weight');?></td>
            </tr>
            
            <?php
                $optionValues   = $assignedOption['optionValues'];
                foreach($optionValues as $index => $optionValueRecord)
                {
            ?>
                    <tr class="option-value-row-<?php echo $optionValueRecord['option_value_id'];?>">
                        <td>
                            <?php echo $optionValueRecord['option_value_name']; ?>
                        </td>
                        <td>
                            <?php echo $optionValueRecord['quantity'];?>
                        </td>
                        <td>
                            <?php echo $optionValueRecord['subtract_stock'] == 1 ? UsniAdaptor::t('application', 'Yes'): UsniAdaptor::t('application', 'No');?>
                        </td>
                        <td>
                            <?php echo $optionValueRecord['price_prefix'] . $optionValueRecord['price'];?> 
                        </td>
                        <td>
                            <?php echo $optionValueRecord['weight_prefix'] . $optionValueRecord['weight'];?> 
                        </td>
                    </tr>
            <?php
                }
            }
        }
        else
        {
        ?>
            <tr>
                <td colspan='6'> <?php echo UsniAdaptor::t('application', 'No results found');?></td>
            </tr>
        <?php
            }
        ?>
    </tbody>
</table>