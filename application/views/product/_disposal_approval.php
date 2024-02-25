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
                  <h5 class="mb-4"><?=$page_title;?></h5>
                  <hr>
                  <form action="<?=base_url();?>Asset/dispose_asset" class="row g-3" method="post">
                     <!--begin line-->
                     <div class="col-md-6">
                        <label class="control-label">Asset Name</label>
                        <input type="text" class="form-control" value="<?php if (!empty($name)){echo $name;}?>" readonly>
                     </div>
                     <div class="col-md-6">
                        <label class="control-label">Barcode</label>
                        <input type="text" class="form-control" value="<?php if (!empty($barcode)){echo $barcode;}?>" readonly>
                     </div>
                     <div class="col-md-12">
                        <label class="control-label">Date</label>
                        <input type="date" name="disposal_date" value="" class="form-control" required=""/>
                     </div>
                     <div class="col-md-12">
                        <input type="hidden" name="asset_id" id="update_id" value="<?=$update_id;?>">
                      
                        <div class="d-md-flex d-grid align-items-center gap-3">
                           <button type="submit" class="btn btn-secondary px-4">Dispose</button>
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
