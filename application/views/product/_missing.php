<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
      <!--breadcrumb-->
      <!--end breadcrumb-->
      <div class="card">
         <div class="card-body">
            <h5 class="card-title">
               <?= $page_title; ?>
            </h5>
            <hr>
            <div class="col">


               <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search..." id="searchInput">
                  <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
               </div>

               <div class="btn-group" style="margin-top:1%;">
                  <?php
                  $role_id = $this->session->userdata('role_id');
                  $name = $this->M_role->get_menu_by_id($menu_id);
                  $ops = $this->M_role->get_role_operations($menu_id, $role_id);
                  $ops1 = $this->M_role->get_menu_operations($menu_id);
                  //echo $menu_id;
                  //var_dump($ops1);
                  $excludeOperations = ['delete', 'view', 'dispose', 'assign_user', 'add_photo', 'revalue', 'read'];
                  foreach ($role_id == 0 ? $ops1 : $ops as $op) {
                     $opDetails = $this->M_role->get_operation_by_id($op['operation_id']);
                     if (!in_array($opDetails, $excludeOperations)) {
                        ?>
                        <a href="#" class="btn btn-warning" id="<?= $opDetails; ?>">
                           <?= ucfirst($opDetails); ?>
                        </a>
                        <?php
                     }
                  }
                  ?>
               </div>
            </div>
            <br>

            <div id="list"></div>

         </div>
      </div>
</main>
<!--end main wrapper-->
<!--start overlay-->
<!--end overlay-->
<?php $this->load->view('includes/footer.php'); ?>
<script>
   $(document).ready(function () {
      load_missing();
      $(".checkall").click(function () {
         $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
      });
   });

   var loader = $('#loader');
   var overlay = $('#overlay');

   function load_missing() {
      overlay.show();
      loader.show();

      $.post('<?= base_url(); ?>Asset/refreshMissing', function (htmlData) {
         $("#list").html(htmlData);
      }).done(function () {
         overlay.hide();
         loader.hide();
      }).fail(function (jqXHR, textStatus, errorThrown) {
         console.error('AJAX Error:', textStatus, errorThrown);
         overlay.hide();
         loader.hide();
      });
   }



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

   $('#recall').click(function (e) {
      var confirmation = confirm("Are you sure you want to RECALL THE SELECTED ASSETS?");
      if (confirmation) {
         recall();
      } else {
      }
   });


   function recall() {

      var assetCheckboxes = $('input[name="asset_id[]"]:checked');
      var selectedAssetIds = assetCheckboxes.map(function () {
         return $(this).val();
      }).get();

      if (selectedAssetIds.length === 0) {
         alert('Please select at least one ASSET to RECALL!!!!');
         loader.hide();
         overlay.hide();
         return;
      }

      loader.show();
      overlay.show();

      $.post('<?= base_url(); ?>Asset/recall', { asset_id: selectedAssetIds })
         .done(function (data) {
            if (data.success) {
               load_missing();
               alert(data.message);
            } else {
               alert(data.message);
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

</script>