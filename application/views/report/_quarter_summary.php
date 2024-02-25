<?php $this->load->view("includes/header.php"); ?>
<?php $this->load->view("includes/menu.php"); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
      <h6 class="mb-0 text-uppercase"><?= $page_title ?></h6>
      <hr>
   </div>
   <div class="card">
   <div class="card-body">
      <div class="table-responsive">
         <div id="list">
            <?php $this->load->view('_refresh_qtr_sum');?>
         </div>
         <button class="btn btn-primary export-btn">Export to Excel</button>
      </div>
   </div>
</main>
<!--end main wrapper-->
<?php $this->load->view("includes/footer.php"); ?>
<script>
   $(document).ready(function(){
     $(".export-btn").click(function(){
         $("#Qsummary").tableHTMLExport({
             type:'csv',
             filename:'<?php echo "All Cost Centres"." ". $quarter_name . " ".$posted_year; ?>.csv',
             });
     });
   });
</script>