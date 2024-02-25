<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
      <!--breadcrumb-->
      <!--end breadcrumb-->
      <div class="row">
         <div class="col-12 col-xl-12">
            <div class="card">
               <div class="card-body p-4">
                  <h5 class="mb-4">
                     <?= $page_title; ?>
                  </h5>
                  <?php if ($this->session->flashdata('message')) { ?>
                     <div class="alert alert-border-success alert-dismissible fade show">
                        <div class="d-flex align-items-center">
                           <div class="font-35 text-success"><span class="material-icons-outlined fs-2">check_circle</span>
                           </div>
                           <div class="ms-3">
                              <h6 class="mb-0 text-success">
                                 <?= $this->session->flashdata('message'); ?>
                              </h6>
                           </div>
                        </div>
                     </div>
                  <?php } ?>
                  <hr>
                  <form id="ImportForm" class="row g-3">
                     <div class="col-md-12">
                        <label class="control-label">Select Excel File</label>
                        <input type="file" name="file" class="form-control" required accept=".xls, .xlsx, .csv">
                     </div>
                     <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                           <button type="button" onclick="import_assets()"
                              class="btn btn-secondary px-4">Import</button>
                        </div>
                     </div>
                     <div class="col-md-12 mt-3">
                        <div class="progress">
                           <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;"
                              aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                     </div>
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
   function import_assets() {
      var fileInput = $('#ImportForm input[name="file"]')[0];
      var file = fileInput.files[0];

      if (!file) {
         alert('Please select a file.');
         return;
      }

      var fileExtension = file.name.split('.').pop().toLowerCase();

      if (['xls', 'xlsx', 'csv'].indexOf(fileExtension) === -1) {
         alert('Please select a valid Excel or CSV file.');
         return;
      }

      var formData = new FormData($('#ImportForm')[0]);

      $.ajax({
         url: '<?= base_url(); ?>Asset/import',
         type: 'POST',
         data: formData,
         dataType: 'json',
         contentType: false,
         processData: false,
         xhr: function () {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (evt) {
               if (evt.lengthComputable) {
                  var percentComplete = (evt.loaded / evt.total) * 100;
                  $('#progressBar').width(percentComplete + '%');
               }
            }, false);
            return xhr;
         },
         beforeSend: function () {
            $('#progressBar').width('0%');
            $('#progressBar').text('0%');
         },
         success: function (data) {
            location.reload();
            alert(data.message);
         },
         error: function (data) {
            alert(data.message);
         },
         complete: function () {
            $('#progressBar').width('0%');
            $('#progressBar').text('0%');
         }
      });
   }
</script>