<main class="main-wrapper">
    <div class="main-content">
        <div class="card">
            <div class="card-body">
                <div id="receipt-container" class="main-content">

                    <hr>
                    <div class="col">
                        <center>
                            <?= $this->db->get('tbl_settings')->row()->company; ?><br>
                            <?= $this->db->get('tbl_settings')->row()->address; ?><br>
                            <?= $this->db->get('tbl_settings')->row()->phone; ?><br>
                            <?= $this->db->get('tbl_settings')->row()->alt_email; ?><br>
                            <?= date('Y-m-d h:m:s:i'); ?>
                        </center>
                        <br>

                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $totalSum = 0;
                            // $total = $this->M_product->get_total_by_sale_id($sale_id);
                            // $vat = $this->M_product->get_vat_by_sale_id($sale_id);
                            // $sub = $this->M_product->get_sub_by_sale_id($sale_id);
                            // $tendered = $this->M_product->get_tendered_by_sale_id($sale_id);
                            // $change = $this->M_product->get_change_by_sale_id($sale_id);

                            $total = 0;
                            $vat = 0;
                            $sub_total = 0;
                            //foreach ($this->M_product->get_sales_by_sale_id($sale_id) as $row): 
                            foreach($receipt_data as $row):
                            $total += $row['total'];
                            $vat += $row['vat'];
                            $sub_total += $row['sub_total'];
                            ?>
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
                                        <?= number_format($row['total'], 2); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" align="right">Sub Total</td>
                                <td>
                                    <?= number_format($sub, 2); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right">VAT</td>
                                <td>
                                    <?= number_format($vat, 2); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right">Total</td>
                                <td>
                                    <?= number_format($total, 2); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right">Tendered</td>
                                <td>
                                    <?= number_format($tendered, 2); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" align="right">Change</td>
                                <td>
                                    <?= number_format($change, 2); ?>
                                </td>
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
            </div>
        </div>
    </div>


</main>