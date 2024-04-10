<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<style>
    .card-body {
        font-family: 'Arial', sans-serif;
        font-size: 16px;
    }

    .card-body h5 {
        font-weight: bold;
        color: #333;
    }

    .form-control {
        font-size: 14px;
    }

    #finish,
    #clearCart {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 20px;
        margin-top: 10px;
        cursor: pointer;
        border-radius: 5px;
    }

    #finish:hover,
    #clearCart:hover {
        background-color: #0056b3;
    }

    .input-group {
        width: 100%;
    }

    .input-group-text {
        background-color: #fff;
        border-color: #ced4da;
        color: #495057;
    }

    .form-control {
        border-color: #ced4da;
    }

    .btn-outline-success {
        border-color: #28a745;
        color: #28a745;
    }

    .input-group {
        width: 100%;
    }

    .input-group-text {
        background-color: #fff;
        border-color: #ced4da;
        color: #495057;
    }

    /* Style for the search icon specifically */
    .input-group-text i {
        color: #28a745;
        /* Icon color */
    }

    /* Style for the select dropdown */
    .form-control {
        border-color: #ced4da;
        /* Border color */
    }

    /* Style for the refresh button */
    .btn-outline-success {
        border-color: #28a745;
        /* Border color */
        color: #28a745;
        /* Text color */
    }

    /* Custom styles for the input group */
    .input-group {
        width: 100%;
    }

    /* Style for the search icon */
    .input-group-text {
        background-color: #fff;
        /* Background color of the input group */
        border-color: #ced4da;
        /* Border color */
        color: #495057;
        /* Text color */
    }

    /* Style for the search icon specifically */
    .input-group-text i {
        color: #28a745;
        /* Icon color */
        font-size: 1.2rem;
        /* Adjust the icon size */
    }

    /* Style for the select dropdown */
    .form-control {
        border-color: #ced4da;
        /* Border color */
    }

    /* Style for the refresh button */
    .btn-outline-success {
        border-color: #28a745;
        /* Border color */
        color: #28a745;
        /* Text color */
    }

    small {
        font-size: 12px;
        color: #777;
        margin-bottom: 5px;
        display: block;
    }

    /* Style for the <select> element */
    #barcode {
        width: 100%;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 14px;
    }
</style>
<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">

        <?php if ($this->session->flashdata('message')) { ?>
            <div class="alert alert-border-success alert-dismissible fade show">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-success"><span class="material-icons-outlined fs-2">check_circle</span>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-success"><?= $this->session->flashdata('message'); ?></h6>
                    </div>
                </div>
            </div>
        <?php } ?>


        <?php if ($this->session->flashdata('error')) { ?>
            <div class="alert alert-border-danger alert-dismissible fade show">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-danger"><span class="material-icons-outlined fs-2">check_circle</span>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-danger"><?= $this->session->flashdata('error'); ?></h6>
                    </div>
                </div>
            </div>
        <?php } ?>

        <form action="<?= base_url(); ?>Move/finish_moving" method="post">

            <div class="row">
                <div class="col-md-12" style="display: flex; flex-direction: column; align-items: center;">
                    <div class="col" style="display: flex; flex-wrap: wrap; margin-bottom: 10px;">
                        <label style="margin-right: 20px;"><input type="radio" name="move_to" value="1"> Shop To
                            Shop</label>
                        <label style="margin-right: 20px;"><input type="radio" name="move_to" value="2"> Shop To
                            Warehouse</label>
                        <label style="margin-right: 20px;"><input type="radio" name="move_to" value="3">
                            Warehouse To Warehouse</label>
                        <label><input type="radio" name="move_to" value="4" true> Warehouse To Shop</label>

                    </div>
                    <div class="col" style="display: flex; flex-wrap: wrap; margin-bottom: 10px;">

                        <select class="form-control" name="from_shop" id="from_shop" style="margin-right: 20px;">
                            <option selected disabled>move from shop</option>
                            <?php foreach ($this->M_shop->get_shops() as $row) { ?>
                                <option value="<?= $row['shop_id']; ?>">
                                    <?= $row['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        &nbsp &nbsp
                        <select class="form-control" name="to_shop" id="to_shop" style="margin-right: 20px;">
                            <option selected disabled>move to shop</option>
                            <?php foreach ($this->M_shop->get_shops() as $row) { ?>
                                <option value="<?= $row['shop_id']; ?>">
                                    <?= $row['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        &nbsp &nbsp
                        <select class="form-control" name="from_wh" id="from_wh" style="margin-right: 20px;">
                            <option selected disabled>move from warehouse</option>
                            <?php foreach ($this->M_warehouse->get_warehouses() as $row) { ?>
                                <option value="<?= $row['warehouse_id']; ?>">
                                    <?= $row['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        &nbsp &nbsp
                        <select class="form-control" name="to_wh" id="to_wh" style="margin-right: 20px;">
                            <option selected disabled>move to warehouse</option>
                            <?php foreach ($this->M_warehouse->get_warehouses() as $row) { ?>
                                <option value="<?= $row['warehouse_id']; ?>">
                                    <?= $row['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col" style="display: flex; flex-wrap: wrap; margin-bottom: 10px;">
                        <select class="form-control" name="receiver" id="receiver">
                            <option selected disabled>Receiver</option>
                            <?php foreach ($this->M_user->get_users() as $row) { ?>
                                <option value="<?= $row['user_id']; ?>">
                                    <?= $row['name']; ?> |
                                    <?= $row['phone']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col" style="display: flex; flex-wrap: wrap; margin-bottom: 10px;">
                        <textarea class="form-control" name="description" id="description"
                            placeholder="description"></textarea>
                    </div>
                    <div class="col" style="display: flex; flex-wrap: wrap; margin-bottom: 10px;">
                        <button class="btn btn-danger" id="clear_cart">Clear Cart</button>
                        &nbsp &nbsp&nbsp &nbsp
                        <button type="submit" class="btn btn-primary" id="finish_moveee">Finish Moving the
                            Products</button>

                    </div>
                </div>

            </div>
        </form>
        <hr>

        <style>
            #barcode {
                padding: 8px;
                border-radius: 5px;
                border: 1px solid #ccc;
                width: 100%;
                box-sizing: border-box;
                margin-bottom: 10px;
                font-size: 20px;
            }

            #productList ul {
                list-style-type: none;
                padding: 0;
                margin: 0;
            }

            #productList li {
                padding: 8px;
                cursor: pointer;
            }

            #productList li:hover {
                background-color: #f0f0f0;
            }

            #productList {
                position: absolute;
                z-index: 1000;
                background-color: #fff;
                border: 1px solid #ccc;
                border-radius: 5px;
                max-height: auto;
                overflow-y: auto;
                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
                width: 50%;
                margin-top: -2px;
            }

            /* Style for the search results list */
            #searchResults {
                list-style-type: none;
                padding: 0;
                margin: 0;
            }

            /* Style for each product item in the search results */
            .product-item {
                padding: 8px;
                cursor: pointer;
            }

            .product-item:hover {
                background-color: #f0f0f0;
            }
        </style>

        <div class="row">
            <div class="col-12 col-xl-12">
                <b><small>Search Product by Barcode, Name or Category</small></b>

                <input id="barcode" name="barcode" type="search" placeholder="Search Product barcode">
                <div id="productList">
                    <ul id="searchResults"></ul>
                </div>

                <br>
                <div id="list">
                    <?php $this->load->view('move/_load_cart'); ?>
                </div>
            </div>

        </div>
        <!--end row-->
    </div>
</main>



<?php $this->load->view('includes/footer.php'); ?>
<script src="<?= base_url(); ?>assets/js/customMove.js"></script>
<script>
    $(document).ready(function () {
        //load_cart();

        $('#barcode').on('input', function () {
            var barcode = $(this).val();
            if (barcode.length >= 3) {
                $.ajax({
                    url: '<?= base_url('Move/search_product'); ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        barcode: barcode
                    },
                    success: function (response) {
                        var searchResults = $('#searchResults');
                        searchResults.empty();
                        if (response && response.length > 0) {
                            response.forEach(function (product) {
                                searchResults.append('<li class="product-item">' +
                                    product.barcode + ' - ' + product.name + ' - ' +
                                    product.desc + '</li>');
                            });
                            $('#productList').show();
                        } else {
                            $('#productList').hide();
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Error searching products. Please try again.');
                    }
                });
            } else {
                $('#productList').hide();
            }
        });

        $(document).on('click', '.product-item', function () {
            var selectedText = $(this).text().trim();
            var barcode = selectedText.split(' - ')[0];
            $('#barcode').val(barcode);
            search();
            $('#barcode').val("").focus();
            $('#productList').hide();
        });

    });
</script>