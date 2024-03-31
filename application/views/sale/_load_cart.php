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


    .quantity-container {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-container input[type="text"] {
        width: 40px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 0 5px;
        padding: 5px;
        background-color: #f9f9f9;
    }

    .quantity-container button {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .quantity-container button:hover {
        background-color: #0056b3;
    }
</style>



<table id="cart" class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th align="center">Qty</th>
            <th>Total</th>
            <th>Remove</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalSum = 0;
        foreach ($this->M_product->get_cart() as $row):
            $vat = $this->db->get('tbl_settings')->row()->vat;
            $totalForRow = (($vat / 100) * ($row['price'] * $row['qty'])) + ($row['price'] * $row['qty']);
            $totalSum += $totalForRow;

            ?>
            <tr>
                <td>
                    <?= $this->M_product->get_name($row['product_id']); ?>
                </td>
                <td>
                    <?= number_format($row['price'], 2); ?>
                </td>
                <td align="center">
                    <div class="quantity-container">
                        <input type="hidden" name="cart_id[]" value="<?= $row['cart_id']; ?>">
                        <button type="button" class="minus-btn">-</button>
                        <input type="text" class="quantity" name="qty[]" value="<?= $row['qty']; ?>">
                        <button type="button" class="plus-btn">+</button>
                    </div>
                </td>

                <td>
                    <?= number_format($row['total'], 2); ?>
                </td>
                <td align="center">
                    <a href="#" onclick="delete_cart(<?= $row['cart_id']; ?>)" class="btn btn-sm btn-danger">
                        <i class="fas fa-times-circle"></i>
                    </a>
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url(); ?>assets/js/custom.js"></script>

<script>
    $('.quantity').on('click', function () {
        $(this).val('');
    });

    var debounceTimer;

    $('.quantity').on('keyup', function () {
        clearTimeout(debounceTimer); // Clear the previous timer

        debounceTimer = setTimeout(() => {
            var cartId = $(this).closest('tr').find('input[name="cart_id[]"]').val();
            var newQuantity = $(this).val();
            updateCartQuantity(cartId, newQuantity);
        }, 500);
    });



    function updateCartQuantity(cartId, newQuantity) {
        $.ajax({
            url: '<?= base_url("Sale/update_cart"); ?>',
            method: 'POST',
            data: { cart_id: cartId, qty: newQuantity },
            success: function (response) {
                load_cart();
                console.log(response)
            },
            error: function (xhr, status, error) {
                console.error('Error updating cart item quantity:', error);
            }
        });
    }


    $('.plus-btn').click(function () {
        var inputField = $(this).siblings('.quantity');
        var currentValue = parseInt(inputField.val());
        var newQuantity = currentValue + 1;
        var cartId = inputField.closest('tr').find('input[name="cart_id[]"]').val();
        updateCartQuantity(cartId, newQuantity);
        inputField.val(newQuantity);
    });


    $('.minus-btn').click(function () {
        var inputField = $(this).siblings('.quantity');
        var currentValue = parseInt(inputField.val());
        var newQuantity = currentValue - 1;
        var cartId = inputField.closest('tr').find('input[name="cart_id[]"]').val();
        updateCartQuantity(cartId, newQuantity);
        inputField.val(newQuantity);
    });

</script>