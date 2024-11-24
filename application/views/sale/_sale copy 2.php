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
               SALE</button>

            <button class="btn btn-outline-warning" id="pause-sale" style="margin-right: 7px;">PAUSE
               SALE</button>

            <button class="btn btn-primary" style="margin-right: 7px;" data-bs-toggle="modal"
               data-bs-target="#PAUSED">PAUSED</button>
         </div>
         <select class="form-control" name="payment_type_id" id="payment_type_id">
            <?php foreach ($this->M_payment_type->get_payment_types() as $row) { ?>
               <option value="<?= $row['payment_type_id']; ?>">
                  <?= $row['payment_type']; ?>
               </option>
            <?php } ?>
         </select>
         &nbsp;

         <select class="form-control" name="client_id" id="client_id">
            <?php foreach ($this->M_client->get_clients_pos() as $row) { ?>
               <option value="<?= $row['client_id']; ?>">
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




         @media print {
            #print-receipt-container {
               display: block;
               margin: 0 auto;
               /* Center the receipt on the page */
            }

            .receipt-table-wrapper {
               /* Additional styles for table container in receipt format */
            }

            #kato {
               /* Adjust styles for table within the receipt format (e.g., font size, margins) */
               border-collapse: collapse;
               /* Ensure table borders collapse for printing */
            }

            #kato th,
            #kato td {
               border: 1px solid black;
               /* Print table borders */
               padding: 5px;
               /* Add padding for better readability */
            }

            .center-align {
               text-align: center;
               margin: 0 auto;
            }
         }
      </style>

      <div class="row">
         <div class="col-8 col-xl-8">
            <b><small>Search Product by Barcode, Name or Category</small></b>

            <input id="barcode" name="barcode" type="search" placeholder="Search Product barcode" autofocus="true">
            <div id="productList">
               <ul id="searchResults"></ul>
            </div>
            <br>
            <table class="table table-bordered" id="kato">
               <thead>
                  <tr>
                     <th>Product</th>
                     <th>Price</th>
                     <th align="center" style='width:100px;'>Qty</th>
                     <th align="center">Vat</th>
                     <th align="center">Total</th>
                     <th align="center">X</th>
                  </tr>
               </thead>
               </thead>
               <tbody id="cart-items-body"></tbody>
            </table>
         </div>

         <div class="col-4 col-xl-4 noprint">
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

                  <div class="input-group mb-3">
                     <br>
                     <input type="text" name="details" id="details" class="form-control" placeholder="Payment Details"
                        style="padding:2%; font-size:30px; text-align: center;">
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

                  <button type="button" id="finish-sale" class="btn btn-success" style="width:100%;">
                     FINISH SALE
                  </button>
               </div>
            </div>

         </div>

      </div>

   </div>
</main>

<div class="modal fade" id="PAUSED" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
   style="width:100%">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">PAUSED SALES</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body" style="">
            <table id="" class="table table-striped" style="width:100%">
               <thead>
                  <tr>
                     <th>Session ID</th>
                     <th>Paused Date</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  foreach ($this->M_product->get_paused_sales() as $row): ?>

                     <tr class="product-row" data-product-id="<?= $row['cart_id']; ?>">
                        <td>
                           <?= $row['session_id'] ?>
                        </td>
                        <td>
                           <?= date('d F Y h:m:s', strtotime($row['date_paused'])); ?>
                        </td>
                        <td>
                           <a href="#" class="btn btn-outline-success">select</a>
                           <a href="#" onclick="delete_cart('<?= $row['session_id']; ?>')"
                              class="btn btn-outline-danger">remove</a>

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

<script>
   $(document).ready(function () {
      clear_bills();

      $('#tendered').on('click', function () {
         $(this).val('');
      });

      $("#tendered").on("input", function () {
         var tenderedAmount = parseFloat(
            $(this)
               .val()
               .replace(/[^\d.]/g, "")
         );
         var totalBill = parseFloat(
            $("#totalBill")
               .text()
               .replace(/[^\d.]/g, "")
         );
         if (tenderedAmount > 0) {
            var change = tenderedAmount - totalBill;
            change = Math.round(change * 100) / 100;
            var formattedChange = change
               .toFixed(2)
               .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $("#change").text("CHANGE: " + formattedChange);
            $("#change").show();
         } else {
            $("#change").hide();
         }
      });


      $(document).on('keypress', function (e) {
         if (e.which === 13) {
            $('#finish-sale').click();
            location.reload();
         }
      });

   });


   function delete_cart(session_id) {
      $.post("<?= base_url(); ?>Sale/delete_cart", { session_id: session_id }, function (htmlData) {
         location.reload();
      }).fail(function (jqXHR, textStatus, errorThrown) {
         console.error("AJAX Error:", textStatus, errorThrown);
      });
   }

   var cartItems = [];
   function search() {
      $.post(
         "<?= base_url(); ?>Sale/refresh_cart",
         {
            barcode: $("#barcode").val()
         },
         function (data) {
            if (data.success) {
               var cartItemsBody = $("#cart-items-body");
               var vatRate = 16.5; // Assume this is fetched from an API
               var quantity = 1;

               // Function to create a new row for each item in the cart
               function createRow(item) {
                  var newRow = $("<tr></tr>");
                  var product_id = item.product_id;
                  var formattedPrice = parseFloat(item.selling_price).toFixed(2);
                  var total = parseFloat(quantity * formattedPrice).toFixed(2);
                  var item_vat = (total * vatRate) / 100;

                  var productInfo = "<td><input type='hidden' name='product_id' value=" + product_id + "><b>" + item.name + "</b><br>" + item.desc + "</td>";
                  var quantityInput = "<td align='center'><input type='text' class='form-control qty-input' style='width:100px;' name='qty[]' value='" + quantity + "'></td>";
                  var deleteButton = "<td align='center'><button class='btn btn-danger delete' data-item-index='" + product_id + "'>X</button></td>";
                  newRow.append(productInfo);
                  newRow.append("<td class='formatted-price'>" + formattedPrice + "</td>");
                  newRow.append(quantityInput);
                  newRow.append("<td class='vat'>" + item_vat.toFixed(2) + "</td>");
                  newRow.append("<td class='price-total'>" + (parseFloat(total)).toFixed(2) + "</td>");
                  newRow.append(deleteButton);
                  cartItemsBody.append(newRow);
                  updateTotals(); // Update totals when a new row is added
               }

               // Add rows for each item in the cart
               data.cart_items.forEach(function (item) {
                  createRow(item);
               });

               // Update totals function
               function updateTotals() {
                  var totalPrice = 0;
                  $('.price-total').each(function () {
                     totalPrice += parseFloat($(this).text());
                  });
                  var totalVat = totalPrice * (vatRate / 100);
                  var totalBill = totalPrice + totalVat;

                  $("#sub").text(totalPrice.toFixed(2));
                  $("#vat").text(totalVat.toFixed(2));
                  $("#totalBill").text(totalBill.toFixed(2));
               }

               $('.qty-input').click(function () {
                  $(this).val('');
               });


               // Update subtotal and total on quantity change
               cartItemsBody.on('input', '.qty-input', function () {
                  var qty = parseInt($(this).val());
                  var row = $(this).closest('tr');
                  var formattedPrice = parseFloat(row.find('.formatted-price').text());
                  var total = (qty * formattedPrice).toFixed(2);
                  var item_vat = (total * vatRate) / 100;
                  row.find('.vat').text(item_vat.toFixed(2));
                  row.find('.price-total').text((parseFloat(total)).toFixed(2));
                  updateTotals();
               });

               // cartItemsBody.on('input', '.qty-input', function () {
               //    var qty = parseInt($(this).val());
               //    var row = $(this).closest('tr');
               //    var formattedPrice = parseFloat(row.find('.formatted-price').text());
               //    var total = (qty * formattedPrice).toLocaleString('en-US', {
               //       minimumFractionDigits: 2,
               //       maximumFractionDigits: 2
               //    });
               //    var item_vat = (total.replace(/,/g, '') * vatRate) / 100; // Remove commas before calculation
               //    row.find('.vat').text(item_vat.toLocaleString('en-US', {
               //       minimumFractionDigits: 2,
               //       maximumFractionDigits: 2
               //    }));
               //    row.find('.price-total').text(parseFloat(total.replace(/,/g, '')).toLocaleString('en-US', {
               //       minimumFractionDigits: 2,
               //       maximumFractionDigits: 2
               //    }));
               //    updateTotals();
               // });


               // Delete item from cart
               cartItemsBody.on('click', '.delete', function () {
                  $(this).closest('tr').remove();
                  updateTotals();
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


   $("#finish-sale").click(function () {
      var productIds = [];
      var vats = [];
      var qtys = [];

      $("#kato tr").each(function () {
         $(this).find(".vat").each(function () {
            vats.push($(this).text());
         });
      });

      $(".qty-input").each(function () {
         qtys.push($(this).val());
      });

      $("input[name='product_id']").each(function () {
         productIds.push($(this).val());
      });

      if (qtys.length !== productIds.length) {
         alert("Please enter quantities for all items.");
         return;
      }

      var dataToSend = {
         product_ids: productIds,
         vats: vats,
         qtys: qtys,
         payment_type_id: $('#payment_type_id').val(),
         tendered: $('#tendered').val(),
         details: $('#details').val(),
         sub_total: $("#sub").html(),
         total_vat: $("#vat").html(),
         total_bill: $("#totalBill").html(),
         client_id: $("#client_id").val(),
      };

      $.ajax({
         url: "<?php echo base_url('Sale/sale_products'); ?>",
         type: "POST",
         data: dataToSend,
         dataType: "json",
         success: function (response) {
            // console.log(response.data[0]);

            // Ensure QZ Tray is initialized
            qz.security.setCertificatePromise(function (resolve, reject) {
               resolve("-----BEGIN CERTIFICATE-----\n...certificate contents...\n-----END CERTIFICATE-----");
            });

            qz.security.setSignaturePromise(function (toSign) {
               return function (resolve, reject) {
                  resolve("...signature...");
               };
            });

            qz.websocket.connect().then(function () {
               console.log("Connected to QZ Tray");
            }).catch(function (err) {
               console.error("Error connecting to QZ Tray:", err);
            });

            // Generate and print receipt using QZ Tray
            // if (response && response.data) {
            //    get_address(function (addressData) {
            //       let receiptText = `
            //                      ${addressData[0].company}\n
            //                      ${addressData[0].address}\n
            //                      ${addressData[0].phone}\n
            //                      --------------------------------\n
            //                      Serial : #${response.data[0].sale_id}\n
            //                      --------------------------------\n
            //                      Item          Price   Qty  Total\n
            //                      --------------------------------\n`;
            //       let subTotal = 0;
            //       let vatTotal = 0;

            //       response.data.forEach((item) => {
            //          const itemSubTotal = parseFloat(item.sub_total || 0);
            //          const itemVat = parseFloat(item.vat || 0);
            //          const price = Number(item.price) || 0;
            //          const total = Number(item.total) || 0;
            //          receiptText += `${item.product_id.padEnd(10)}${price.toFixed(2).padStart(7)}${item.qty.toString().padStart(5)}${total.toFixed(2).padStart(8)}\n`;

            //          subTotal += itemSubTotal;
            //          vatTotal += itemVat;
            //       });

            //       const totalAmount = subTotal + vatTotal;

            //       receiptText += `
            //                   --------------------------------\n
            //                   Sub Total: ${subTotal.toFixed(2)}\n
            //                   Vat      : ${vatTotal.toFixed(2)}\n
            //                   Total    : ${totalAmount.toFixed(2)}\n
            //                   --------------------------------\n`;


            if (response?.data) {
               get_address(async (addressData) => {
                  const address = addressData?.[0] || {};
                  const receiptText = generateReceipt(address, response.data);

                  console.log(receiptText);

                  qz.printers.getDefault().then((defaultPrinter) => {
                     const config = qz.configs.create(defaultPrinter);
                     qz.print(config, [{
                        type: 'raw',
                        format: 'plain',
                        data: receiptText
                     }]).then(() => {
                        console.log("Receipt sent to printer");
                     }).catch((err) => {
                        console.error("Error printing receipt:", err);
                     });
                  }).catch((err) => {
                     console.error("Error getting default printer:", err);
                  });
               });
            }













            // var config = qz.configs.create("Zebra LP2844-Z");
            // // Send to QZ Tray for printing
            // qz.print(config, [{
            //    type: 'raw',
            //    format: 'plain',
            //    data: receiptText
            // }]).then(() => {
            //    console.log("Receipt sent to printer");
            // }).catch((err) => {
            //    console.error("Error printing receipt:", err);
            // });







            //       qz.printers.getDefault().then((defaultPrinter) => {
            //    var config = qz.configs.create(defaultPrinter);
            //    // Send to QZ Tray for printing
            //    qz.print(config, [{
            //       type: 'raw',
            //       format: 'plain',
            //       data: receiptText
            //    }]).then(() => {
            //       console.log("Receipt sent to printer");
            //    }).catch((err) => {
            //       console.error("Error printing receipt:", err);
            //    });
            // }).catch((err) => {
            //    console.error("Error getting default printer:", err);
            // });
            // });
         }
      });



   });









   function generateReceipt(address, salesData) {
      let receiptText = `
${address.company || 'Company Name'}\n
${address.address || 'Company Address'}\n
${address.phone || 'Phone Number'}\n
------------------------------------------------\n
Serial : #${salesData[0]?.sale_id || 'N/A'}\n
------------------------------------------------\n
Item          Price         Qty           Total\n
------------------------------------------------\n`;

      let subTotal = 0;
      let vatTotal = 0;

      salesData.forEach((item) => {
         const itemSubTotal = parseFloat(item?.sub_total || 0);
         const itemVat = parseFloat(item?.vat || 0);
         const price = parseFloat(item?.price || 0);
         const total1 = parseFloat(item?.total || 0) + parseFloat(item?.vat || 0);
         const total = parseFloat(total1 || 0);

         const productId = (item.product_id || 'Unknown').substring(0, 10).padEnd(10);
         const priceStr = price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).padStart(9);
         const qty = (item.qty || 0).toString().padStart(11);
         const totalStr = total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).padStart(17);

         receiptText += `${productId}${priceStr}${qty}${totalStr}\n`;

         subTotal += itemSubTotal;
         vatTotal += itemVat;
      });

      const totalAmount = subTotal + vatTotal;
      receiptText += `
-----------------------------------------------\n
Sub Total: ${subTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}\n
Vat      : ${vatTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}\n
Total    : ${totalAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}\n
------------------------------------------------\n`;
      return receiptText;
   }




   $("#pause-sale").click(function () {
      var productIds = [];
      var qtys = [];


      $(".qty-input").each(function () {
         qtys.push($(this).val());
      });

      $("input[name='product_id']").each(function () {
         productIds.push($(this).val());
      });

      if (qtys.length !== productIds.length) {
         alert("Please enter quantities for all items.");
         return;
      }

      var dataToSend = {
         product_ids: productIds,
         qtys: qtys,
         client_id: $("#client_id").val(),
      };

      $.ajax({
         url: "<?php echo base_url('Sale/sale_pause'); ?>",
         type: "POST",
         data: dataToSend,
         dataType: "json",
         success: function (response) {
            console.log(response);
            clear_bills();
         },
         error: function (xhr, status, error) {
            console.error(xhr.responseText);
            alert(xhr.responseText)
         }
      });
   });


   function clear_bills() {
      var cartItemsBody = $("#cart-items-body");
      cartItemsBody.empty();
      $('#tendered').val("0.00");
      $('#details').val();
      $("#sub").text("00.00");
      $("#vat").text("00.00");
      $("#totalBill").html("00.00");
      $("#change").text("CHANGE: ");
      $("#change").hide();
   }


   // Function to fetch address details
   function get_address(callback) {
      $.ajax({
         url: "<?php echo base_url('Product/get_address'); ?>",
         type: "GET",
         dataType: "json",
         success: function (data) {
            callback(data);
         },
         error: function (xhr, status, error) {
            console.error(xhr.responseText);
            alert("Error fetching address data");
         }
      });
   }


   $('#barcode').on('input', function () {
      var barcode = $("#barcode").val();
      if (barcode.trim() === "") {
         alert("Barcode is required!!!!");
      } else {
         search();
      }
   });

   // $("#barcode").keypress(function (event) {
   //    if (event.which === 13) {
   //       var barcode = $("#barcode").val();
   //       if (barcode.trim() === "") {
   //          alert("Barcode is required!!!!");
   //       } else {
   //          search();
   //       }
   //    }
   // });

   function clearCart() {
      if (confirm("Are you sure you want to clear your cart?")) {
         var cartItemsBody = $("#cart-items-body");
         cartItemsBody.empty();
         $('#tendered').val("0.00");
         $('#details').val();
         $("#sub").text("00.00");
         $("#vat").text("00.00");
         $("#totalBill").html("00.00");
      }
   }

   $(document).ready(function () {
      // Trigger search when Enter is pressed after scanning
      $("#barcode").on("keypress", function (e) {
         if (e.which === 13) { // Check if Enter key is pressed
            search();
            $("#barcode").val(""); // Clear the barcode field after search
         }
      });
   });


   // $('#barcode').on('input', function () {
   //    var barcode = $(this).val();
   //    if (barcode.length >= 2) {
   //       $.ajax({
   //          url: '<?= base_url('Product/search_product'); ?>',
   //          type: 'POST',
   //          dataType: 'json',
   //          data: { barcode: barcode },
   //          success: function (response) {
   //             var searchResults = $('#searchResults');
   //             searchResults.empty();
   //             if (response && response.length > 0) {
   //                response.forEach(function (product) {
   //                   searchResults.append('<li class="product-item">' + product.barcode + ' - ' + product.name + ' - ' + product.desc + '</li>');
   //                });
   //                $('#productList').fadeIn();
   //             } else {
   //                $('#productList').fadeOut();
   //             }
   //          },
   //          error: function (xhr, status, error) {
   //             console.error(xhr.responseText);
   //             alert('Error searching products. Please try again.');
   //          }
   //       });
   //    } else {
   //       $('#productList').fadeOut();
   //    }
   // });



   // $(document).on('click', '.product-item', function () {
   //    var selectedText = $(this).text().trim();
   //    var barcode = selectedText.split(' - ')[0];
   //    $('#barcode').val(barcode);
   //    search();
   //    $('#barcode').val("").focus();
   //    $('#productList').fadeOut();

   // });




</script>