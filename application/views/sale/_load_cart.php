<style>
    #cart {
        width: 100%;
        border-collapse: collapse;
    }

    #cart th,
    #cart td {
        padding: 10px;
        text-align: center;
        vertical-align: middle;
        border: 1px solid #ccc;
    }

    #cart th {
        background-color: #f2f2f2;
    }

    #cart tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #cart tbody tr:hover {
        background-color: #e6f7ff;
    }

    .quantity {
        width: 50px;
        padding: 5px;
        text-align: center;
    }

    .btn-delete {
        color: white;
        background-color: #dc3545;
        border: none;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }
</style>



<table id="cart" class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th align="center">Qty</th>
            <th>VAT</th>
            <th>Sub Total</th>
            <th colspan="2">Total</th>
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
                    <?= number_format($row['price'], 2); ?>
                </td>
                <td align="center">
                    <input type="hidden" name="cart_id[]" value="<?= $row['cart_id']; ?>">
                    <input type="text" class="quantity" name="qty[]" value="<?= $row['qty']; ?>">
                </td>
                <td>
                    <?= number_format($row['vat'], 2); ?>
                </td>
                <td>
                    <?= number_format($row['sub_total'], 2); ?>
                </td>
                <td>
                    <?= number_format($row['total'], 2); ?>
                </td>
                <td align="center">
                    <a href="#" onclick="delete_cart(<?= $row['cart_id']; ?>)" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i>
                    </a>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>