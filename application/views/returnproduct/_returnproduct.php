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
      <h6 class="mb-0 text-uppercase">
         <?= $page_title; ?>
      </h6>
      <hr>

      <div class="col-md-12" style="display: flex; align-items: center; justify-content: space-between;">
         <div class="col">
            <button onclick="clearCart()" class="btn btn-outline-danger" style="margin-right: 7px;">CANCEL
               RETURNING</button>
            <button class="btn btn-outline-success" style="margin-right: 7px;" id="finish-adjusting">FINISH
               RETURNING </button>
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
         <div class="col-8 col-xl-8">
            <b><small>Search Product by Barcode, Name or Category</small></b>

            <input id="barcode" name="barcode" type="search" placeholder="Search Product barcode">
            <div id="productList">
               <ul id="searchResults"></ul>
            </div>
            <br>
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th>Product</th>
                     <th>Price</th>
                     <th align="center">Qty</th>
                     <th>Total</th>
                     <th>X</th>
                  </tr>
               </thead>
               </thead>
               <tbody id="cart-items-body"></tbody>
            </table>
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

                  <button type="submit" id="finish33" class="btn btn-success" style="width:100%;">
                     FINISH SALE
                  </button>
               </div>
            </div>

         </div>

      </div>

   </div>
</main>

<?php $this->load->view('includes/footer.php'); ?>
<script>
   var cartItems = [];
   function search() {
      $.post(
         "<?= base_url(); ?>ReturnProduct/refresh_cart",
         {
            barcode: $("#barcode").val()
         },
         function (data) {

            if (data.success) {
               var cartItemsBody = $("#cart-items-body");
               var subTotal = 0;
               var vatRate = 16.5;
               var quantity = 1;

               $.each(data.cart_items, function (index, item) {
                  var newRow = $("<tr></tr>");
                  var product_id = item.product_id;
                  var formattedPrice = parseFloat(item.selling_price).toFixed(2);
                  var productInfo = "<td><input type='hidden' name='product_id' value=" + product_id + ">" + item.barcode + "<br>" + item.desc + "</td>";
                  var quantityInput = "<td><input type='text' class='form-control qty-input' name='qty[]' value='" + quantity + "'></td>";
                  var deleteButton = "<td><button class='btn btn-danger delete' data-item-index='" + index + "'>X</button></td>";
                  var total = parseFloat(quantity * formattedPrice).toFixed(2);
                  newRow.append(productInfo);
                  newRow.append("<td class='formatted-price'>" + formattedPrice + "</td>");
                  newRow.append(quantityInput);
                  newRow.append("<td class='price-total'>" + total + "</td>");
                  newRow.append(deleteButton);
                  cartItemsBody.append(newRow);

                  newRow.on('input', '.qty-input', function () {
                     var qty = parseInt($(this).val());
                     var row = $(this).closest('tr');
                     var formattedPrice = parseFloat(row.find('.formatted-price').text());
                     calculateSubtotal(row, qty, formattedPrice);
                  });

                  newRow.on('click', '.delete', function () {
                     var row = $(this).closest('tr');
                     var itemIndex = $(this).data('item-index');
                     row.remove();
                     calculateSubtotal(row, 0, 0); // Remove all quantity of deleted item
                  });

                  calculateSubtotal(newRow, quantity, formattedPrice);
               });

               function calculateSubtotal(row, quantity, formattedPrice) {
                  var total = (quantity * formattedPrice).toFixed(2);
                  row.find('.price-total').text(total);

                  updateTotal(); // Update the overall total
               }

               function updateTotal() {
                  var totalPrice = 0;
                  $('.price-total').each(function () {
                     totalPrice += parseFloat($(this).text());
                  });
                  $("#sub").text(totalPrice.toFixed(2));
               }
            } else {
               $("#cart-items").html("<p>" + data.message + "</p>");
            }



         },
         "json"
      ).fail(function (jqXHR, textStatus, errorThrown) {
         $("#barcode").val("");
      });
   }



   $("#finish-adjusting").click(function () {
      var prices = [];
      var productIds = [];

      $(".price-input").each(function () {
         prices.push($(this).val());
      });

      $("input[name='product_id']").each(function () {
         productIds.push($(this).val());
      });

      if (prices.length !== productIds.length) {
         alert("Please enter prices for all items.");
         return;
      }

      var dataToSend = {
         product_ids: productIds,
         prices: prices
      };

      $.ajax({
         url: "<?php echo base_url('ReturnProduct/save_new_prices'); ?>",
         type: "POST",
         data: dataToSend,
         dataType: "json",
         success: function (response) {
            console.log(response);
            alert(response.message)
            var cartItemsBody = $("#cart-items-body");
            cartItemsBody.empty();
         },
         error: function (xhr, status, error) {
            console.error(xhr.responseText);
            alert(response.message)
         }
      });
   });

   $("#barcode").keypress(function (event) {
      if (event.which === 13) {
         var barcode = $("#barcode").val();
         if (barcode.trim() === "") {
            alert("Barcode is required!!!!");
         } else {
            search();
         }
      }
   });

   function clearCart() {
      if (confirm("Are you sure you want to clear your cart?")) {
         var cartItemsBody = $("#cart-items-body");
         cartItemsBody.empty();
      }
   }

   $('#barcode').on('input', function () {
      var barcode = $(this).val();
      if (barcode.length >= 2) {
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


</script>