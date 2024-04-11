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

      <form action="<?= base_url(); ?>Receive/finish_receive" method="POST">
         <div class="col-md-12" style="display: flex; align-items: center; justify-content: space-between;">
            <div class="col">
               <a href="" class="btn btn-outline-success" style="margin-right: 7px;" data-bs-toggle="modal"
                  data-bs-target="#SearchProduct">Lookup <i class="fa fa-search"></i></a>
               <a id="clear_cart" href="" class="btn btn-outline-danger" style="margin-right: 7px;">Clear
                  <i class="fa fa-trash"></i></a>
            </div>

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
            <div class="col-12 col-xl-12">
               <b><small>Search Product by Barcode, Name or Category</small></b>

               <input id="barcode" name="barcode" type="search" placeholder="Search Product barcode">
               <div id="productList">
                  <ul id="searchResults"></ul>
               </div>

               <br>
               <div id="list">
                  <?php $this->load->view('receive/_load_cart'); ?>
               </div>
            </div>

            <style>
               .form-group {
                  display: flex;
                  /* Make the container a flexbox */
               }

               .form-group select,
               .form-group .input-group {
                  margin-right: 10px;
                  /* Add some margin between elements */
               }

               .form-group select:last-child,
               .form-group .input-group:last-child {
                  margin-right: 0;
                  /* Remove margin from the last element */
               }

               .form-group {
                  display: flex;
                  /* Make the container a flexbox */
                  align-items: center;
                  /* Vertically align elements in the center */
               }

               .form-group select {
                  margin-right: 10px;
                  /* Add space between selects */
               }

               .form-group .input-group {
                  margin-left: 10px;
                  /* Add space between input and last select */
               }
            </style>

            <div class="col-12 col-xl-12">
               <div class="card">
                  <div class="card-body p-4">
                     <h5 class="mb-4">
                        <b>TOTAL COST: <span id="totalBill"></span></b>
                     </h5>
                     <hr>
                     <div class="form-group">
                        <select class="form-control" name="shop_id" id="shop_id">
                           <option selected disabled>RECEIVE TO SHOP</option>
                           <?php foreach ($this->M_shop->get_shops() as $row) { ?>
                              <option value="<?= $row['shop_id']; ?>">
                                 <?= $row['name']; ?>
                              </option>
                           <?php } ?>
                        </select>
                        &nbsp;&nbsp;
                        <select class="form-control" name="warehouse_id" id="warehouse_id">
                           <option selected disabled>RECEIVE TO WAREHOUSE</option>
                           <?php foreach ($this->M_warehouse->get_warehouses() as $row) { ?>
                              <option value="<?= $row['warehouse_id']; ?>">
                                 <?= $row['name']; ?>
                              </option>
                           <?php } ?>
                        </select>
                        &nbsp;&nbsp;
                        <select class="form-control" name="supplier_id" id="supplier_id" required>
                           <option selected disabled>SUPPLIER</option>
                           <?php foreach ($this->M_supplier->get_suppliers() as $row) { ?>
                              <option value="<?= $row['supplier_id']; ?>">
                                 <?= $row['name']; ?> | <?= $row['phone']; ?>
                              </option>
                           <?php } ?>
                        </select>

                     </div>
                     <br>
                     <input type="text" name="order_details" id="order_details" class="form-control"
                        placeholder="Order Details" required>
                     <br>
                     <button type="submit" id="finishS" class="btn btn-success" style="width:20%;">
                        FINISH RECEIVING
                     </button>
                  </div>
               </div>

            </div>
         </div>
      </form>
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
<script src="<?= base_url(); ?>assets/js/customReceive.js"></script>
<script>
   $(document).ready(function () {
      load_cart();



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