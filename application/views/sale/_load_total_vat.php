<?php
$vatTotal = $this->M_product->get_total_vat_cart();
?>

<span>
    <?= number_format($vatTotal, 2); ?>
</span>