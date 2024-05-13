<?php
$user_id = $this->session->userdata('user_id');
$client_id = $this->input->post('client_id');
$shop_id = $this->M_user->get_user_shop($user_id);
$vatTotal = $this->M_product->get_total_vat_cart($user_id,$client_id,$shop_id);
?>

<span>
    <?= number_format($vatTotal, 2); ?>
</span>