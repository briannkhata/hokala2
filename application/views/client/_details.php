<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<style>
   .modal-header {
      padding: 10px 20px;
      background-color: #f5f5f5;
      border-bottom: 1px solid #ddd;
   }

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
      <?php
      //$client_id = $this->M_client->get_walk_in_client();
      ?>
      <div class="col-md-12" style="display: flex; align-items: center; justify-content: space-between;">
         <div class="col">
            <a href="" class="btn btn-outline-success" style="margin-right: 7px;" data-bs-toggle="modal"
               data-bs-target="#NewClient">Client <i class="fa fa-plus-circle"></i></a>
            <a href="" class="btn btn-outline-success" style="margin-right: 7px;" data-bs-toggle="modal"
               data-bs-target="#SearchProduct">Product <i class="fa fa-search"></i></a>
            <a id="clear_cart" href="" class="btn btn-outline-danger" style="margin-right: 7px;">Clear
               <i class="fa fa-trash"></i></a>
         </div>
         <select class="form-control" name="client_id" id="client_id" onchange="load_cart()">
            <?php foreach ($this->M_client->get_clients_pos() as $row) { ?>
               <option <?=$client_id == $row['client_id']?"seletected":"";?> value="<?= $row['client_id']; ?>">
                  <?= $row['name']; ?> |
                  <?= $row['phone']; ?>
               </option>
            <?php } ?>
         </select>
      </div>
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
         <div class="col-8 col-xl-8">
            <b><small>Search Product by Barcode, Name or Category</small></b>

            <input id="barcode" name="barcode" type="search" placeholder="Search Product barcode">
            <div id="productList">
               <ul id="searchResults"></ul>
            </div>

            <br>
            <div id="list">
               <?php $this->load->view('sale/_load_cart'); ?>
            </div>
         </div>


         <div class="col-4 col-xl-4">
            <div class="card">
               <div class="card-body p-4">
                  <h5 class="mb-4">
                     <b>SUB : <span id="sub"></span></b>
                     <hr>
                     <b>VAT : <span id="vat"></span></b>
                     <hr>
                     <b>TOTAL : <span id="totalBill"></span></b>
                  </h5>
                  <hr>
                  <select class="form-control" name="payment_type_id" id="payment_type_id">
                     <?php foreach ($this->M_payment_type->get_payment_types() as $row) { ?>
                        <option value="<?= $row['payment_type_id']; ?>">
                           <?= $row['payment_type']; ?>
                        </option>
                     <?php } ?>
                  </select>

                  <div id="detailsInputField">
                     <br>
                     <input type="text" name="details" id="details" class="form-control" placeholder="Payment Details">
                     <br>
                  </div>
                  <br>
                  <div class="input-group mb-3">
                    
                     <input type="text" name="tendered" id="tendered" class="form-control"
                        style="padding:2%; font-size:30px; text-align: center; font-weight:bold;" required>
                  </div>

                  <h5 class="mb-4">
                     <span id="change"></span>
                  </h5>
                  <h5 class="mb-4">
                     <span id="balance"></span>
                  </h5>

                  <button type="submit" id="finish" class="btn btn-success" style="width:100%;">
                     FINISH SALE
                  </button>
               </div>
            </div>

         </div>
      </div>
      <!--end row-->
   </div>
</main>



<div class="modal fade" id="SearchProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
   style="width:100%">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Search Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body" style="">
            <table id="proSearch" class="table table-striped" style="width:100%">
               <thead>
                  <tr>
                     <th>Barcode</th>
                     <th>Product</th>
                     <th>Description</th>
                     <th>Price</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  foreach ($this->M_product->get_products() as $row): ?>

                     <tr class="product-row" data-product-id="<?= $row['product_id']; ?>">
                        <td>
                           <?= $row['barcode'] ?>
                        </td>
                        <td>
                           <?= $row['name'] ?>
                        </td>
                        <td>
                           <?= $row['desc'] ?>
                        </td>
                        <td>
                           <?= number_format($row['selling_price'], 2) ?>
                        </td>
                     </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>

      </div>
   </div>
</div>


<?php $this->load->view('includes/footer.php'); ?>
<script src="<?= base_url(); ?>assets/js/custom.js"></script>
<script>
   $(document).ready(function () {
      //load_cart();
      $('#detailsInputField').hide();

      $('#payment_type_id').change(function () {
         var selectedText = $(this).find('option:selected').text();
         if (selectedText === 'CASH') {
            $('#detailsInputField').hide();
         } else {
            $('#detailsInputField').show();
         }
      });

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

      $('.product-row').on('click', function () {
         var productId = $(this).data('product-id');
         $.ajax({
            url: '<?= base_url(); ?>Sale/refresh_cart',
            method: 'POST',
            data: { product_id: productId },
            success: function (response) {
               load_cart();
            },
            error: function (xhr, status, error) {
               console.log(xhr.responseText);
               alert('Error adding product to cart. Please try again.');
            }
         });
      });


      $('#saveBtn').click(function () {
         var formData = $('#NewClientForm').serialize();
         $.ajax({
            url: '<?= base_url('Client/save_client'); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
               console.log(response);
               location.reload();
            },
            error: function (xhr, status, error) {
               location.reload();
            }
         });
      });


      $('#barcode').on('input', function () {
         var barcode = $(this).val();
         if (barcode.length >= 3) {
            $.ajax({
               url: '<?= base_url('Product/search_product'); ?>',
               type: 'POST',
               dataType: 'json',
               data: { barcode: barcode },
               success: function (response) {
                  var searchResults = $('#searchResults');
                  searchResults.empty();
                  if (response && response.length > 0) {
                     response.forEach(function (product) {
                        searchResults.append('<li class="product-item">' + product.barcode + ' - ' + product.name + ' - ' + product.desc + '</li>');
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