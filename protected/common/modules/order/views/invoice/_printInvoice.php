<?php
use usni\UsniAdaptor;
?>
<div class="container">
    <div style="page-break-after: always;">
        <h1><?php echo $title; ?></h1>
        <table class="table table-bordered">
            <thead><tr><td colspan="2"><?php echo '<strong>' . UsniAdaptor::t('order', 'Order Details') . '</strong>'?></td></tr></thead>
            <tr>
                <td style="width:50%">
                    <?php echo $companyAddress; ?>
                </td>
                <td style="width:50%">
                    <?php echo $invoiceSummary; ?>
                </td>
            </tr>
        </table>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td style="width: 33%;"> <?php echo '<strong>' . UsniAdaptor::t('order', 'Bill To') . ':' . '</strong>'; ?> </td>
                    <td style="width: 33%;"> <?php echo '<strong>' . UsniAdaptor::t('order', 'Ship To') . ':' . '</strong>'; ?> </td>
                    <td style="width: 33%;"> <?php echo '<strong>' . UsniAdaptor::t('users', 'Person Details') . ':' . '</strong>'; ?> </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php echo $billToAddress; ?>
                    <?php echo $shipToAddress; ?>
                    <?php echo $personDetails; ?>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <?php echo $orderDetails; ?>
    </div>
    <div class="row">
        <?php echo $paymentDetails ?>
    </div>
</div>
<!--script>
    //@see http://stackoverflow.com/questions/17753420/jquery-print-function-to-print-div-content-with-css
//    function printInvoice()
//    {
//        window.print();
//    }
</script-->