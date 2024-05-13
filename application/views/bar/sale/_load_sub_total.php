<?php
$user_id = $this->session->userdata('user_id');
$client_id = $this->input->post('client_id');
$shop_id = $this->M_user->get_user_shop($user_id);
$subTotal = $this->M_product->get_sub_total_sum_cart($user_id, $client_id, $shop_id);

?>

<span><?=number_format($subTotal,2);?></span>
<?