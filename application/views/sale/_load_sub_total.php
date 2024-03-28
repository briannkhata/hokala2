<?php
$subTotal = $this->M_product->get_sub_total_sum_cart();
?>

<span><?=number_format($subTotal,2);?></span>
<?