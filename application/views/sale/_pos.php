<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">

      <div class="col-md-12" style="display: flex; align-items: center; justify-content: space-between;">
         <div class="col">
            <a href="" class="btn btn-outline-success" style="margin-right: 7px;">New Sale <i
                  class="fa fa-plus-circle"></i></a>
            <a href="" class="btn btn-outline-primary" style="margin-right: 7px;">New Client <i
                  class="fa fa-plus-circle"></i></a>
            <a href="" class="btn btn-outline-danger" style="margin-right: 7px;">Clear Cart / Sale <i
                  class="fa fa-trash"></i></a>
         </div>
         <select class="form-control" name="client_id" id="client_id" required="">
            <?php foreach ($this->M_client->get_clients() as $row) { ?>
               <option value="<?= $row['client_id']; ?>">
                  <?= $row['name']; ?> |
                  <?= $row['phone']; ?>
               </option>
            <?php } ?>
         </select>
      </div>

      <hr>
      <style>
         .input-group {
            width: 100%;
         }

         .input-group-text {
            background-color: #fff;
            /* Background color of the input group */
            border-color: #ced4da;
            /* Border color */
            color: #495057;
            /* Text color */
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
      </style>

      <div class="row">
         <div class="col-8 col-xl-8">
            <div class="input-group" style="margin-top: 10px;">
               <div class="input-group-prepend">
                  <span class="input-group-text">
                     SEARCH
                  </span>
               </div>

               <select class="form-control" name="barcode" id="barcode" required="" onchange="search()">
                  <option selected="" disabled="">----</option>
                  <?php foreach ($this->M_product->get_products_pos() as $row) { ?>
                     <option value="<?= $row['barcode']; ?>">
                        <?= $row['name']; ?> | MK:
                        <?= number_format($row['selling_price'], 2); ?> |
                        <?= $row['desc']; ?>
                     </option>
                  <?php } ?>
               </select>
               <button class="btn btn-outline-success" type="button" id="refreshSale">U | Refresh</button>
            </div>

            <br>

            <form action="<?= base_url(); ?>Sale/update_cart" method="post" id="update-cart">
               <div id="list">
                  <?php $this->load->view('sale/_load_cart'); ?>
               </div>
            </form>
         </div>


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
         </style>


         <div class="col-4 col-xl-4">
            <div class="card">
               <div class="card-body p-4">
                  <form action="<?= base_url(); ?>Sale/finish_sale" method="post" id="finishSale">
                     <h5 class="mb-4">
                        <b>SUB : <span id="sub"></span></b>
                        <hr>
                        <b>VAT : <span id="vat"></span></b>
                        <hr>
                        <b>TOTAL : <span id="totalBill"></span></b>
                     </h5>
                     <hr>

                     <div class="input-group mb-3">
                        <input type="text" name="tendered" id="tendered" class="form-control"
                           style="padding:2%; font-size:30px; text-align: center; font-weight:bold;" required>

                     </div>

                     <h5 class="mb-4">
                        <span id="change"></span>
                     </h5>

                     <button type="submit" id="finish" class="form-control">
                        P | FINISH SALE
                     </button>
                  </form>
               </div>
            </div>
         </div>

      </div>
      <!--end row-->
   </div>
</main>
<!--end main wrapper-->
<?php $this->load->view('includes/footer.php'); ?>
<script src="<?= base_url(); ?>assets/js/custom.js"></script>
<script>
   $(document).ready(function () {
      load_cart();
      
      $('#tendered').on('input', function () {
         var input = $(this).val().replace(/[^\d.-]/g, '');
         var parts = input.split('.');
         parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
         if (parts[1]) {
            parts[1] = parts[1].substring(0, 2);
         }
         var formatted = parts.join('.');
         $(this).val(formatted);
      });


      $(document).keypress(function (event) {
         var keycode = event.keyCode ? event.keyCode : event.which;
         if (keycode == "117") {
            $("#refreshSale").click();
         }

         var keycode = event.keyCode ? event.keyCode : event.which;
         if (keycode == "112") {
            finish();
         }
      });
   });
</script>