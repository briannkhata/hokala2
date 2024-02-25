<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<main class="main-wrapper">
   <div class="main-content">
   <div class="row">
      <div class="col-12 col-xl-12">
         <div class="card">
            <div class="card-body p-4">
               <h5 class="mb-4"><?=$page_title;?></h5>
               <hr>
               <form role="form" class="row g-3" id="formRunDep" method="post">
                  <div class="col-md-6">
                     <select class="form-control" name="quarter" required="">
                        <option selected="" disabled="">Quarter</option>
                        <option <?php echo ($quarter_number == 1) ? 'selected' : '' ?> value='1'>1st Quarter</option>
                        <option <?php echo ($quarter_number == 2) ? 'selected' : '' ?> value='2'>2nd Quarter</option>
                        <option <?php echo ($quarter_number == 3) ? 'selected' : '' ?> value='3'>3rd Quarter</option>
                        <option <?php echo ($quarter_number == 4) ? 'selected' : '' ?> value='4'>4th Quarter</option>
                     </select>
                  </div>
                  <div class="col-md-6">
                     <select class="form-control" name="year" required="">
                        <option selected="" disabled="">Year</option>
                        <?php 
                           for ($i = 2020 ; $i <= date('Y'); $i++){ ?>  
                        <option value="<?=$i;?>" <?php if($i == date('Y') ) echo 'selected';?>><?=$i;?></option>
                        <?php }?>
                     </select>
                  </div>
                  <div class="col-md-12">
                     <div class="d-md-flex d-grid align-items-center gap-3">
                        <button type="button" onclick="run_depreciation()" class="btn btn-secondary">Run</button>
                     </div>
               </form>
               </div>
            </div>
         </div>
      </div>
      <!--end row-->
   </div>
</main>
<?php $this->load->view('includes/footer.php'); ?>
<script>
   function  run_depreciation() {
     var isConfirmed = confirm('Are you sure you want to CONTINUE?');
        if (!isConfirmed) {
           return;
        }
   var formData = $('#formRunDep').serialize();
   $.ajax({
       url: '<?=base_url();?>Asset/run_quarter_dep',
       type: 'POST', 
       data: formData,
       dataType: 'json',
       beforeSend: function() {
           $('#loader').show();
           $('#overlay').show();
       },
       success: function(data) {
          $('#loader').hide();
           $('#overlay').hide();
          alert(data.message);
       },
       error: function() {
           console.log('Error saving data.');
       },
       complete: function() {
           $('#loader').hide();
           $('#overlay').hide();
           //alert(data.message);
       }
   });
   }
   
</script>