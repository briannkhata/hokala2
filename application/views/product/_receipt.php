<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<main class="main-wrapper">
    <div class="main-content">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <?= $page_title; ?>
                </h5>
                <hr>
                <div class="col">
                   <center>
                        <?=$this->db->get('tbl_settings')->row()->company;?><br>
                        <?=$this->db->get('tbl_settings')->row()->address;?><br>
                        <?=$this->db->get('tbl_settings')->row()->phone;?><br>
                        <?=$this->db->get('tbl_settings')->row()->alt_email;?><br>
                        <?=date('Y-m-d h:m:s:i');?>
                   </center>
                   <br>

                </div>

                     <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>VAT</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php 


// var_dump($this->M_product->get_sales_by_sale_id($sale_id));
// return;
                     
                            $totalSum = 0;
                            $total = $this->M_product->get_total_by_sale_id($sale_id);
                            $vat = $this->M_product->get_vat_by_sale_id($sale_id);
                            $sub = $this->M_product->get_sub_by_sale_id($sale_id);
                            $tendered = $this->M_product->get_tendered_by_sale_id($sale_id);
                            $change = $this->M_product->get_change_by_sale_id($sale_id);
                            foreach ($this->M_product->get_sales_by_sale_id($sale_id) as $row): ?>
                                <tr>
                                    <td>
                                        <?= $this->M_product->get_name($row['product_id']); ?>
                                    </td>
                                    <td>
                                        <?= number_format($row['price'], 2); ?>
                                    </td>
                                    <td>
                                        <?= $row['qty']; ?>
                                    </td>
                                    <td>
                                        <?= number_format($row['vat'], 2); ?>
                                    </td>
                                    <td>
                                        <?= number_format($row['total'], 2); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" align="right">Sub Total</td>
                                <td><?= number_format($sub, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right">VAT</td>
                                <td><?= number_format($vat, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right">Total</td>
                                <td><?= number_format($total, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right">Tendered</td>
                                <td><?= number_format($tendered, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right">Change</td>
                                <td><?= number_format($change, 2); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="col">
                        <div class="btn-group">

                            <a href="#" class="btn btn-secondary" onclick="window.print()">
                                PRINT
                            </a>


                        </div>
                    </div>
                </div>

</main>

<?php $this->load->view('includes/footer.php'); ?>