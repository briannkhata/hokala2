<?php
$user_id = $this->session->userdata('user_id');
?>
<span><?=number_format($this->M_receive->get_total_sum_cart($user_id),2);?></span>
