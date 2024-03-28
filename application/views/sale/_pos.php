<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
      <!--breadcrumb-->
      <!--end breadcrumb-->
      <div class="row">
         <div class="col-8 col-xl-8">
            <h5 class="mb-4">
               Search Below:
            </h5>

            <div class="col">
               <div class="input-group" style="margin-top: 10px;">
                  <select class="form-control" name="barcode" id="barcode" required="" onchange="search()">
                     <option selected="" disabled="">----</option>
                     <?php foreach ($this->M_product->get_products_pos() as $row) { ?>
                        <option value="<?= $row['barcode']; ?>">
                           <?= $row['name']; ?> |
                           MK:
                           <?= number_format($row['selling_price'], 2); ?> |
                           <?= $row['desc']; ?>
                        </option>
                     <?php } ?>
                  </select>
                  <button class="btn btn-outline-success" type="button" id="refreshSale">U | Refresh</button>
               </div>
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
                  <form action="<?= base_url(); ?>Product/finish_sale" method="post" id="update-cart">
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
                     <br>
                     <button class="form-control" type="button" id="clearCart"><b style="color:red;">REMOVE/CLEAR
                           SALE</b></button>
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
   });

   $(document).keypress(function (event) {
      var keycode = (event.keyCode ? event.keyCode : event.which);
      if (keycode == '117') { 
         $("#refreshSale").click(); 
      }

      var keycode = (event.keyCode ? event.keyCode : event.which);
      if (keycode == '112') { 
         finish();
      }
   });

   $("#refreshSale").on("click", function () {
      $("table#cart tbody tr").each(function () {
         var quantity = $(this).find(".quantity").val();
         var cartId = $(this).find("input[name='cart_id[]']").val();
         $.ajax({
            url: "<?= base_url(); ?>Product/update_cart",
            type: "POST",
            data: { cart_id: cartId, qty: quantity },
            dataType: 'json',
            success: function (response) {
               load_cart();
               console.log(response);
            },
            error: function (xhr, status, error) {
               console.error(xhr.responseText);
            }
         });
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


   // $('#search').click(function (e) {
   //    var barcode = $('#barcode').val();
   //    if (barcode.trim() === '') {
   //       alert('Barcode is required!!!');
   //       e.preventDefault();
   //    } else {
   //       search();
   //    }
   // });


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



   $('#tendered').on('input', function () {
    var tenderedAmount = parseFloat($(this).val().replace(/[^\d.]/g, ''));
    var totalBill = parseFloat($('#totalBill').text().replace(/[^\d.]/g, ''));
    if (tenderedAmount > 0) {
        var change = tenderedAmount - totalBill;
        change = Math.round(change * 100) / 100;
        var formattedChange = change.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        $('#change').text('CHANGE: ' + formattedChange);
        $('#change').show(); // Show the change field
    } else {
        $('#change').hide(); // Hide the change field if no value is entered
    }
});



   function finish() {
      var tenderedAmount = $('#tendered').val();

      if (!tenderedAmount || isNaN(tenderedAmount)) {
         alert('Please enter a valid tendered amount.');
         return;
      }

      $.post('<?= base_url(); ?>Sale/finish_sale', {
         tendered: tenderedAmount
      })
         .fail(function (jqXHR, textStatus, errorThrown) {
            console.log('AJAX Error:', textStatus, errorThrown);
            alert('An error occurred while processing your request.');
         });
   }


   function search() {
      $.post('<?= base_url(); ?>Sale/refresh_cart', {
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
      $.post('<?= base_url(); ?>Sale/cancel', {
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
      $.post('<?= base_url(); ?>Sale/refreshCart', function (htmlData) {
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
      $.post('<?= base_url(); ?>Sale/refresh_total_bill', function (htmlData) {
         $("#totalBill").html(htmlData);
      }).fail(function (jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
         // Handle error here if needed
      });
   }

   function refresh_sub_total() {
      $.post('<?= base_url(); ?>Sale/refresh_sub_total_bill', function (htmlData) {
         $("#sub").html(htmlData);
      }).fail(function (jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
         // Handle error here if needed
      });
   }

   function refresh_vat_total() {
      $.post('<?= base_url(); ?>Sale/refresh_total_vat', function (htmlData) {
         $("#vat").html(htmlData);
      }).fail(function (jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
         // Handle error here if needed
      });
   }

   function delete_cart(cart_id) {
      $.post('<?= base_url(); ?>Sale/delete_cart', { cart_id: cart_id }, function (htmlData) {
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