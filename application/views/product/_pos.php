<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
      <!--breadcrumb-->
      <!--end breadcrumb-->
      <div class="row">
         <div class="col-8 col-xl-8">
            <div class="card">
               <div class="card-body p-4">
                  <h5 class="mb-4">
                     Search Below:
                  </h5>


                  <div class="col">


                     <div class="input-group" style="margin-top:%;">
                        <input type="text" class="form-control" placeholder="Search with barcode..." id="barcode"
                           name="barcode">
                        <button class="btn btn-outline-secondary" type="button" id="search">Search</button>
                     </div>
                  </div>
                  <br>

                  <div id="list"></div>

               </div>
            </div>
         </div>

         <div class="col-4 col-xl-4">
            <div class="card">
               <div class="card-body p-4">
                  <h5 class="mb-4">
                     <b>MK : <span id="totalBill"></span></b>
                  </h5>
                  <hr>

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
      total_bill();
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


   $('#cancel').click(function (e) {
      var confirmed = confirm("Are you sure you want to CANCEL auditing?");
      if (confirmed) {
         cancel();
      } else {
         e.preventDefault();
      }
   });

   $('#finish').click(function (e) {
      var confirmed = confirm("Are you sure you want to FINISH auditing?");
      if (confirmed) {
         finish();
      } else {
         e.preventDefault();
      }
   });

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
            console.error('AJAX Error:', textStatus, errorThrown);
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
      $.post('<?= base_url(); ?>Asset/cancel', {
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

   function delete_cart(cart_id) {
      $.post('<?= base_url(); ?>Product/delete_cart', { cart_id: cart_id }, function (htmlData) {
         load_cart();
         refresh_total_bill();
      }).fail(function (jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
         // Handle error here if needed
      });
   }

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





</script>