<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<main class="main-wrapper">
   <div class="main-content">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title">
               <?= $page_title; ?>
            </h5>
            <hr>
            <div class="col">
               <div class="btn-group">
                  <a href="<?= base_url(); ?>Asset/run_audit" class="btn btn-secondary">
                     Back
                  </a>
                 
               </div>

               <div class="input-group" style="margin-top:3%;">
                  <input type="text" class="form-control" placeholder="Search with barcode..." id="barcode"
                     name="barcode">
                  <input type="hidden" id="centre_id" name="centre_id" value="<?= $centre_id; ?>">
                  <button class="btn btn-outline-secondary" type="button" id="search">Search</button>
               </div>
            </div>
            <br>

            <div id="list"></div>
         </div>
      </div>
</main>
<?php $this->load->view('includes/footer.php'); ?>
<script>
   $(document).ready(function () {
      load_cart();
   });

   $('#centre_id, #barcode').keypress(function (event) {
      if (event.which === 13) {
         var centreId = $('#centre_id').val();
         var barcode = $('#barcode').val();
         if (centreId.trim() === '' || barcode.trim() === '') {
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
      $.post('<?= base_url(); ?>Asset/search_asset_and_add_to_cart', {
         centre_id: $('#centre_id').val(),
         barcode: $('#barcode').val()
      }, function (data) {
         if (data.success) {
            $('#centre_id').val('');
            $('#barcode').val('');
            load_cart();
         } else {
            alert(data.message);
            $('#centre_id').val('');
            $('#barcode').val('');
         }
      }, 'json')
         .fail(function (jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
            alert('An error occurred while processing your request.');
            $('#centre_id').val('');
            $('#barcode').val('');
         });
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

   function pause() {
      $('#loader').show();
      $('#overlay').show();
      $.post('<?= base_url(); ?>Asset/pause', {
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

   function finish() {
      $('#loader').show();
      $('#overlay').show();
      $.post('<?= base_url(); ?>Asset/finish', {
         centre_id: $('#centre_id'),
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
      $.post('<?= base_url(); ?>Asset/refreshCart', function (htmlData) {
         $("#list").html(htmlData);
      }).fail(function (jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
         // Handle error here if needed
      });
   }

   function delete_cart(audit_id) {
      $.post('<?= base_url(); ?>Asset/delete_cart', { audit_id: audit_id }, function (htmlData) {
         load_cart();
      }).fail(function (jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
         // Handle error here if needed
      });
   }


</script>