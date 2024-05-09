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
            <!-- <button  class="btn btn-outline-primary" style="margin-right: 7px;">PAUSE
               ADJUSTING</button> -->
            <button onclick="clearCart()" class="btn btn-outline-danger" style="margin-right: 7px;">CANCEL
               ADJUSTING</button>
            <button class="btn btn-outline-success" style="margin-right: 7px;" id="finish-adjusting">FINISH
               ADJUSTING </button>
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
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th>Product</th>
                     <th>Description</th>
                     <th>Old Price</th>
                     <th>New Price</th>
                     <th>Remove</th>
                  </tr>
               </thead>
               <tbody id="cart-items-body"></tbody>
            </table>
         </div>

      </div>

   </div>
</main>

<?php $this->load->view('includes/footer.php'); ?>
<script>
   var cartItems = [];
   function search() {
      $.post(
         "<?= base_url(); ?>AdjustPrice/refresh_cart",
         {
            barcode: $("#barcode").val()
         },
         function (data) {
            if (data.success) {
               var cartItemsBody = $("#cart-items-body");
               //cartItemsBody.empty();
               //data.cart_items.reverse();
               $.each(data.cart_items, function (index, item) {
                  var newRow = $("<tr></tr>");
                  newRow.append("<td><input type='hidden'  name='product_id' value=" + item.product_id + ">" + item.name + "</td>");
                  newRow.append("<td>" + item.desc + "</td>");
                  var formattedPrice = parseFloat(item.selling_price).toFixed(2).replace(/\d(?=(\d{3})+(?!\d))/g, ",");
                  newRow.append("<td> MK " + formattedPrice + "</td>");
                  newRow.append("<td><input type='text' class='form-control price-input' name='price[]'></td>");
                  newRow.append("<td><button class='btn btn-danger delete' data-item-index='" + index + "'>X</button></td>");
                  cartItemsBody.append(newRow);
               });

               $(".delete").click(function () {
                  var removeIndex = $(this).data("item-index");
                  $(this).closest("tr").remove();
               });

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
         url: "<?php echo base_url('AdjustPrice/save_new_prices'); ?>",
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