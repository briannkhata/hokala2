<table id="cart" class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th align="center">Qty</th>
            <th>VAT</th>
            <th>Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalSum = 0;
        foreach ($this->M_product->get_cart() as $row): 
        $vat = $this->db->get('tbl_settings')->row()->vat;
        $totalForRow = (($vat / 100) * ($row['price'] * $row['qty'])) + ($row['price'] * $row['qty']);
        $totalSum += $totalForRow; // Accumulate total
 
        ?>
            <tr>
                <td>
                    <?= $this->M_product->get_name($row['product_id']); ?>
                </td>
                <td>
                    <?= $row['price']; ?>
                </td>
                <td align="center">
                    <input type="hidden" name="cart_id[]" value="<?= $row['cart_id']; ?>">
                    <input type="text" class="quantity" name="qty[]" value="<?= $row['qty']; ?>">
                </td>
                <td>
                    <?= $row['vat']; ?>
                </td>

                <td>
                    <?= $row['total']; ?>
                </td>

                <td align="center">
                    <a href="#" onclick="delete_cart(<?= $row['cart_id']; ?>)" class="btn btn-sm btn-danger">
                        Remove
                    </a>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>