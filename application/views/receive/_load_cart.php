<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

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

    .quantity-container1 {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-container1 input[type="text"] {
        width: 100%;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 0 5px;
        padding: 5px;
        background-color: #f9f9f9;
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

    .empty-cart-message {
        font-size: 18px;
        /* Adjust font size as needed */
        color: #333;
        /* Text color */
        padding: 10px;
        /* Padding around the text */
        margin: 10px 0;
        /* Margin to create space around the element */
        background-color: #f5f5f5;
        /* Background color */
        border: 1px solid #ccc;
        /* Border style */
        border-radius: 5px;
        /* Border radius for rounded corners */
        text-align: center;
        /* Center-align the text */
    }
</style>

<?php
$user_id = $this->session->userdata('user_id');
$shop_id = $this->M_user->get_user_shop($user_id);
$cart = $this->M_receive->get_cart($user_id);
if (count($cart) <= 0):
    ?>
    <div class="empty-cart-message">NO ITEMS ON THE CART</div>
<?php else: ?>
    <table id="cart" class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Selling Price</th>
                <th>Cost Price</th>
                <th align="center">Qty</th>
                <th>Total Cost</th>
                <th>Expiry Date</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($cart as $row):
                ?>
                <tr>
                    <td>
                        <?= $this->M_product->get_name($row['product_id']); ?><br>
                        <small><b><?= $this->M_product->get_barcode($row['product_id']); ?></b></small>
                        <input type="hidden" name="cart_id[]" value="<?= $row['cart_id']; ?>">
                    </td>
                    <td>
                        <div class="quantity-container1">
                            <input type="text" class="price" name="price[]" value="<?=$row['price']; ?>">
                        </div>
                    </td>
                    <td>
                        <div class="quantity-container1">
                            <input type="text" class="cost_price" name="cost_price[]"
                                value="<?= $row['cost_price']; ?>">
                        </div>
                    </td>
                    <td align="center">
                        <div class="quantity-container">
                            <input type="text" class="quantity" name="qty[]" value="<?= $row['qty']; ?>">
                        </div>
                    </td>

                    <td>
                        <?= number_format($row['total_cost'], 2); ?>
                    </td>
                    <td align="center">
                        <div class="quantity-container1">
                            <input type="date" class="expiry_date" name="expiry_date[]" value="<?= $row['expiry_date']; ?>">
                        </div>
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
<?php endif; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?= base_url(); ?>assets/js/customReceive.js"></script>

<script>

    $('.quantity').on('click', function () {
        $(this).val('');
    });

    $('.cost_price').on('click', function () {
        $(this).val('');
    });

    $('.price').on('click', function () {
        $(this).val('');
    });


    // $('.expiry_date').on('change', function () {
    //     var row = $(this).closest('tr');
    //     var cartId = row.find('input[name="cart_id[]"]').val();
    //     var NewPrice = parseFloat(row.find('input[name="price[]"]').val());
    //     var NewCost = parseFloat(row.find('input[name="cost_price[]"]').val());
    //     var newQuantity = parseFloat(row.find('input[name="qty[]"]').val());
    //     var expiryDate = row.find('input[name="expiry_date[]"]').val();
    //     updateCartQuantity(cartId, newQuantity, NewCost, expiryDate, NewPrice);
    // });

    $('.cost_price, .quantity,.price,.expiry_date').on('input', function () {
        var row = $(this).closest('tr');
        var cartId = row.find('input[name="cart_id[]"]').val();
        var NewPrice = parseFloat(row.find('input[name="price[]"]').val());
        var NewCost = parseFloat(row.find('input[name="cost_price[]"]').val());
        var newQuantity = parseFloat(row.find('input[name="qty[]"]').val());
        var expiryDate = row.find('input[name="expiry_date[]"]').val();
        updateCartQuantity(cartId, newQuantity, NewCost, expiryDate, NewPrice);
    });

    //var debounceTimer;

    // $('.quantity').on('input', function () {
    //     clearTimeout(debounceTimer);
    //     debounceTimer = setTimeout(() => {
    //         var cartId = $(this).closest('tr').find('input[name="cart_id[]"]').val();
    //         var cost_price = $(this).closest('tr').find('input[name="cost_price[]"]').val();
    //         var newQuantity = $(this).val();
    //         updateCartQuantity(cartId, newQuantity, cost_price);
    //     }, 500);
    // });

    // $('.cost_price').on('input', function () {
    //     clearTimeout(debounceTimer);
    //     debounceTimer = setTimeout(() => {
    //         var cartId = $(this).closest('tr').find('input[name="cart_id[]"]').val();
    //         var newQuantity = $(this).closest('tr').find('input[name="quantity[]"]').val();
    //         var cost_price = $(this).val();
    //         updateCartQuantity(cartId, newQuantity, cost_price);
    //     }, 500);
    // });



    function updateCartQuantity(cartId, newQuantity, NewCost, expiryDate, NewPrice) {
        $.ajax({
            url: '<?= base_url("Receive/update_cart"); ?>',
            method: 'POST',
            data: { cart_id: cartId, qty: newQuantity, cost_price: NewCost, expiry_date: expiryDate, price: NewPrice },
            success: function (response) {
                load_cart();
                console.log(response)
            },
            error: function (xhr, status, error) {
                console.error('Error updating cart item quantity:', error);
            }
        });
    }


    // $('.plus-btn').click(function () {
    //     var inputField = $(this).siblings('.quantity');
    //     var currentValue = parseInt(inputField.val());
    //     var newQuantity = currentValue + 1;
    //     var cost_price = inputField.closest('tr').find('input[name="cost_price[]"]').val();
    //     var cartId = inputField.closest('tr').find('input[name="cart_id[]"]').val();
    //     updateCartQuantity(cartId, newQuantity);
    //     inputField.val(newQuantity);
    // });


    // $('.minus-btn').click(function () {
    //     var inputField = $(this).siblings('.quantity');
    //     var currentValue = parseInt(inputField.val());
    //     var newQuantity = currentValue - 1;
    //     var cartId = inputField.closest('tr').find('input[name="cart_id[]"]').val();
    //     updateCartQuantity(cartId, newQuantity);
    //     inputField.val(newQuantity);
    //     //$('#change').text('');
    //     //$('#tendered').text('');
    // });

</script>