<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
      <h6 class="mb-0 text-uppercase">
         <?= $page_title; ?>
      </h6>
      <hr>
      <div class="btn-group">

         <?php
         $role_id = $this->session->userdata('role_id');
         $name = $this->M_role->get_menu_by_id($menu_id);
         $ops = $this->M_role->get_role_operations($menu_id, $role_id);
         $ops1 = $this->M_role->get_menu_operations($menu_id);
         $excludeOperations = ['delete', 'view', 'read'];
         foreach ($role_id == 0 ? $ops1 : $ops as $op) {
            $opDetails = $this->M_role->get_operation_by_id($op['operation_id']);
            if (!in_array($opDetails, $excludeOperations)) {
               ?>
               <a href="#" id="<?= $opDetails; ?>" class="btn btn-secondary">
                  <?= ucfirst($opDetails); ?>
               </a>
               <?php
            }
         }
         ?>
      </div>

      <br><br>
      <div class="input-group">
         <input type="text" class="form-control" placeholder="Search..." id="searchInput">
         <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
      </div>

      <br>
      <div id="list">
      </div>
   </div>
   </div>
   </div>
</main>

<?php $this->load->view('includes/footer.php'); ?>
<script>
   $(document).ready(function () {
      load_disposal();
      $('.checkall').click(function () {
         var isChecked = $(this).prop('checked');
         $('.table tbody input[type="checkbox"]').prop('checked', isChecked);
      });
   });

   $('#searchButton').on('click', function () {
      performSearch();
   });

   // Search functionality on input change
   $('#searchInput').on('input', function () {
      performSearch();
   });

   function performSearch() {
      var searchValue = $('#searchInput').val().toLowerCase();
      $('table tbody tr').each(function () {
         var text = $(this).text().toLowerCase();
         $(this).toggle(text.indexOf(searchValue) !== -1);
      });
   }

   function load_disposal() {
      $.get('<?= base_url(); ?>Asset/refreshDisposal', function (htmlData) {
         $("#list").html(htmlData);
      }).fail(function (jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
      });
   }


   $('#reject').click(function (e) {
      var confirmation = confirm("Are you sure you want to REJECT DISPOSAL?");
      if (confirmation) {
         reject();
      } else {
      }
   });

   $('#approve').click(function (e) {
      var confirmation = confirm("Are you sure you want to APPROVE DISPOSAL?");
      if (confirmation) {
         dispose();
      } else {
      }
   });


   function dispose() {
      var loader = $('#loader');
      var overlay = $('#overlay');
      var assetCheckboxes = $('input[name="asset_id[]"]:checked');
      var selectedAssetIds = assetCheckboxes.map(function () {
         return $(this).val();
      }).get();

      if (selectedAssetIds.length === 0) {
         alert('Please select at least one ASSET to dispose!!!!');
         loader.hide();
         overlay.hide();
         return;
      }

      loader.show();
      overlay.show();

      $.post('<?= base_url(); ?>Asset/approve_disposal', { asset_id: selectedAssetIds })
         .done(function (data) {
            if (data.success) {
               alert(data.message);
               load_disposal();
            } else {
               alert(data.message);
            }
         })
         .fail(function (jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
            alert('An error occurred while processing your request.');
         })
         .always(function () {
            loader.hide();
            overlay.hide();
         });
   }




   function reject() {
      $('#loader').show();
      $('#overlay').show();

      var selectedAssetIds = [];
      $('input[name="asset_id[]"]:checked').each(function () {
         selectedAssetIds.push($(this).val());
      });

      if (selectedAssetIds.length === 0) {
         alert('Please select at least one ASSET!!!!');
         $('#loader').hide();
         $('#overlay').hide();
         return;
      }
      $.post('<?= base_url(); ?>Asset/approve_disposal', { asset_id: selectedAssetIds }, function (data) {
         if (data.success) {
            alert(data.message);
            load_disposal();
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




</script>