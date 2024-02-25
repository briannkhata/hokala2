<div class="overlay btn-toggle"></div>
<!--<footer class="page-footer">
   <p class="mb-0">Copyright © <?php //echo date('Y');  ?> All right reserved.</p>
   </footer>-->
<script src="<?= base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="<?= base_url(); ?>assets/plugins/metismenu/metisMenu.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="<?= base_url(); ?>assets/js/main.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/table2csv.js"></script>
<script src="<?= base_url(); ?>assets/js/select2.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/select2/js/select2-custom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
   function previewImage(input) {
      var file = input.files[0];

      if (file) {
         var reader = new FileReader();
         reader.onload = function (e) {
            $('#photoPreview').html('<img src="' + e.target.result + '" class="img-fluid" alt="Preview" style="width:150px; height:100px;">');
         }
         reader.readAsDataURL(file);
      }
   }
   //$('#loader').show();
   // $('#overlay').show();
   $(document).ready(function () {
      $('#example').DataTable();
      setTimeout(function () {
         if (document.querySelector('.alert')) {
            document.querySelector('.alert').style.display = 'none';
         }
      }, 5000);
   });
</script>
</body>

</html>