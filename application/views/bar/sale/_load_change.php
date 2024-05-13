<?php
$vatTotal = $this->M_product->get_total_vat_cart();
$totalBill = $this->M_product->get_total_sum_cart();
$subTotal = $totalBill - $vatTotal;
?>

<span><?=number_format($subTotal,2);?></span>
<?