<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
      <!--breadcrumb-->
      <!--end breadcrumb-->
      <div class="row">
         <div class="col-8 col-xl-8">
            <div class="card-body p-4">
               <h5 class="mb-4">
                  Search Below:
               </h5>


               <div class="col">


                  <div class="input-group" style="margin-top:%;">
                     <select class="form-control" name="barcode" id="barcode" required="" onchange="search()">
                        <option selected="" disabled="">----</option>
                        <?php foreach ($this->M_product->get_products() as $row) { ?>
                           <option value="<?= $row['barcode']; ?>">
                              <?= $row['barcode']; ?> |
                              <?= $row['name']; ?>
                           </option>
                        <?php } ?>
                     </select>
                     <button class="btn btn-outline-secondary" type="button" id="search">Search</button>
                     <button class="btn btn-outline-secondary" type="button" id="clearCart">Clear Cart</button>
                  </div>

               </div>
               <br>

               <div id="list"></div>

            </div>
         </div>

         <div class="col-4 col-xl-4">
            <div class="card">
               <div class="card-body p-4">
                  <h5 class="mb-4">
                     <b>Sub : <span id="sub"></span></b>
                     <hr>
                     <b>Vat : <span id="vat"></span></b>
                     <hr>
                     <b>Total : <span id="totalBill"></span></b>
                  </h5>
                  <hr>
                  Tendered Amount :
                  <input type="text" name="tendered" id="tendered" class="form-control" style="padding:2%;">
                  <hr>
                  <h5 class="mb-4">
                     <center>
                        <span id="change"></span>
                     </center>
                  </h5>

                  <h5 class="mb-4">
                     <button type="button" id="finish" class="form-control">
                        FINISH SALE
                     </button>

                  </h5>
               </div>
            </div>
         </div>
      </div>
      <!--end row-->
   </div>
</main>
<!--end main wrapper-->
<?php $this->load->view('includes/footer.php'); ?>
<script>
   $(document).ready(function () {
      load_cart();

      $('.quantity').on('keydown', function (event) {
         //if (event.keyCode === 13) {
         var quantity = $(this).val();
         console.log("Captured quantity:", quantity);
         return false;
         //  }
      });






      function updateCart(cart_id, qty) {
         $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>Product/update_cart',
            data: {
               cart_id: cart_id,
               qty: qty
            },
            success: function (response) {
               console.log(response);
            }
         });
      }

      $('.quantity').on('change', function () {
         var cart_id = $(this).prev().val();
         var qty = $(this).val();
         alert(qty);
         if (qty.trim() !== '') {
            updateCart(cart_id, qty);
         } else {
            console.log('Quantity is empty.');
         }
      });

      $('.quantity').on('keydown', function (e) {
         if (e.keyCode === 13) { // Check if Enter key is pressed
            var cart_id = $(this).prev().val();
            var qty = $(this).val();

            if (qty.trim() !== '') {
               updateCart(cart_id, qty);
            } else {
               console.log('Quantity is empty.');
            }
         }
      });
   });

   $('#barcode').keypress(function (event) {
      if (event.which === 13) {
         var barcode = $('#barcode').val();
         if (barcode.trim() === '') {
            alert('Barcode is required!!!!');
         } else {
            search();
         }
      }
   });


   $('#search').click(function (e) {
      var barcode = $('#barcode').val();
      if (barcode.trim() === '') {
         alert('Barcode is required!!!');
         e.preventDefault();
      } else {
         search();
      }
   });


   $('#clearCart').click(function (e) {
      var confirmed = confirm("Are you sure you want to CLEAR CART?");
      if (confirmed) {
         cancel();
      } else {
         e.preventDefault();
      }
   });

   $('#finish').click(function (e) {
      finish();
   });

   $('#tendered').keypress(function (event) {
      // Check if the pressed key is Enter (key code 13)
      if (event.which === 13) {
         event.preventDefault();
         finish();
      }
   });

   $('#tendered').on('keyup', function () {
      var tenderedValue = parseFloat($(this).val());
      var totalBillValue = $('#totalBill').text();

      totalBillValue = parseFloat(totalBillValue);

      if (!isNaN(tenderedValue) && !isNaN(totalBillValue)) {
         var difference = tenderedValue - totalBillValue;
         $('#change').text(difference.toFixed(2)); // Display the result in the span with id 'change'
      }
   });


   function finish() {
      var tenderedAmount = $('#tendered').val();

      if (!tenderedAmount || isNaN(parseFloat(tenderedAmount))) {
         alert('Please enter a valid tendered amount.');
         return;
      }
      $.post('<?= base_url(); ?>Product/finish_sale', {
         tendered: tenderedAmount
      }, function (data) {
         if (data.success) {
            load_cart();
            $('#barcode').val('');
         } else {
            alert(data.message);
         }
      }, 'json')
         .fail(function (jqXHR, textStatus, errorThrown) {
            console.log('AJAX Error:', textStatus, errorThrown);
            alert('An error occurred while processing your request.');
            $('#tendered').val('');
         });
   }

   function search() {
      $.post('<?= base_url(); ?>Product/add_to_cart', {
         barcode: $('#barcode').val()
      }, function (data) {
         if (data.success) {
            $('#barcode').val('');
            load_cart();
         } else {
            alert(data.message);
            $('#barcode').val('');
         }
      }, 'json')
         .fail(function (jqXHR, textStatus, errorThrown) {
            console.log('AJAX Error:', textStatus, errorThrown);
            alert('An error occurred while processing your request.');
            $('#barcode').val('');
         });
   }

   function total_bill() {
      var sum = 0;
      $('#cart tbody tr').each(function () {
         var total = parseFloat($(this).find('td:eq(4)').text());
         sum += total;
      });
      $('#totalSum').html(sum);
   }

   function cancel() {
      $('#loader').show();
      $('#overlay').show();
      $.post('<?= base_url(); ?>Product/cancel', {
      }, function (data) {
         if (data.success) {
            alert(data.message)
            load_cart();
         } else {
            alert(data.message);
         }
      }, 'json')
         .fail(function (jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
            alert('An error occurred while processing your request.');
         })
         .always(function () {
            $('#loader').hide();
            $('#overlay').hide();
         });
   }






   function load_cart() {
      $.post('<?= base_url(); ?>Product/refreshCart', function (htmlData) {
         $("#list").html(htmlData);
         refresh_total_bill();
         refresh_sub_total();
         refresh_vat_total();
         //$('#change').text('');
         $('#tendered').val('');
      }).fail(function (jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
         // Handle error here if needed
      });
   }

   function refresh_total_bill() {
      $.post('<?= base_url(); ?>Product/refresh_total_bill', function (htmlData) {
         $("#totalBill").html(htmlData);
      }).fail(function (jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
         // Handle error here if needed
      });
   }

   function refresh_sub_total() {
      $.post('<?= base_url(); ?>Product/refresh_sub_total_bill', function (htmlData) {
         $("#sub").html(htmlData);
      }).fail(function (jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
         // Handle error here if needed
      });
   }

   function refresh_vat_total() {
      $.post('<?= base_url(); ?>Product/refresh_total_vat', function (htmlData) {
         $("#vat").html(htmlData);
      }).fail(function (jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
         // Handle error here if needed
      });
   }

   function delete_cart(cart_id) {
      $.post('<?= base_url(); ?>Product/delete_cart', { cart_id: cart_id }, function (htmlData) {
         load_cart();
         refresh_total_bill();
         refresh_sub_total();
         refresh_vat_total();
      }).fail(function (jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
         // Handle error here if needed
      });
   }







</script>