<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<main class="main-wrapper">
   <div class="main-content">
   <div class="card">
      <div class="card-body">
         <h5 class="card-title"><?=$page_title;?></h5>
         <hr>
         <div class="col">
            <div class="btn-group">
               <a id="FinishAudit" class="btn btn-secondary">Excel</a>
            </div>
            <!-- Add the search box here -->
           
         </div>
         <br>

        <div id="list"></div>
       
      </div>
   </div>
</main>
<?php $this->load->view('includes/footer.php'); ?>
<script>
   $(document).ready(function(){
   $('#searchButton').on('click', function() {
       performSearch();
   });
   
   // Search functionality on input change
   $('#searchInput').on('input', function() {
       performSearch();
   });
   
    $('#examplee thead th input[type="checkbox"]').on('change', function() {
       var isChecked = $(this).prop('checked');
       $('#examplee tbody td input[type="checkbox"]').prop('checked', isChecked);
   });
   
   
   $('#FinishAudit').on('click', function() {
      var selectedAssetIds = [];
   
       if ($('#examplee tbody td input[type="checkbox"]:checked').length === 0) {
           alert('Please select at least one Asset to FINISH AUDIT');
       } else {
          $('#examplee tbody td input[type="checkbox"]:checked').each(function() {
             selectedAssetIds.push($(this).val());
          });
         $.ajax({
              url: '<?=base_url();?>Asset/finish_audit',
              type: 'POST', 
              data: { asset_id: selectedAssetIds },
              dataType: 'json',
              beforeSend: function() {
                 $('#loader').show();
                 $('#overlay').show();
              },
              success: function(data) {
                 $('#loader').hide();
                 $('#overlay').hide();
                 alert(data.message);
                 location.reload();
              },
              error: function() {
                 console.log('Error saving data.');
              },
              complete: function() {
                 $('#loader').hide();
                 $('#overlay').hide();
                 alert(data.message);
                 location.reload();
              }
           });
   
       }
   });
   
   
   function performSearch() {
       var searchValue = $('#searchInput').val().toLowerCase();
       $('table tbody tr').each(function() {
           var text = $(this).text().toLowerCase();
           $(this).toggle(text.indexOf(searchValue) !== -1);
       });
   }
   
   

    $.ajax({
        url: '<?=base_url();?>Asset/refreshfinished',
        type: 'POST',
        dataType: 'html', // Assuming the server returns HTML content
        beforeSend: function() {
            $('#loader').show();
            $('#overlay').show();
        },
        success: function(htmlData) {
            $('#loader').hide();
            $('#overlay').hide();
            $("#list").html(htmlData);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('AJAX Error:', textStatus, errorThrown);
            $('#loader').hide();
            $('#overlay').hide();
        }
       
    });


   
   });
</script>