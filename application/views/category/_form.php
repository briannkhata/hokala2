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
                              <h6 class="mb-0 text-success"><?= $this->session->flashdata('message'); ?></h6>
                           </div>
                        </div>
                     </div>
                  <?php } ?>
                  <hr>
                  <form action="<?= base_url(); ?>Category/save" id="form" class="row g-3" method="post">
                     <div class="col-md-6">
                        <label class="control-label">Category</label>
                        <input type="text" name="category" class="form-control" value="<?php if (!empty($category)) {
                           echo $category;
                        } ?>" required="">
                     </div>
                     <div class="col-md-6">
                        <label class="control-label">UN Code</label>
                        <input type="text" name="un_code" class="form-control" value="<?php if (!empty($un_code)) {
                           echo $un_code;
                        } ?>">
                     </div>
                     <div class="col-md-12">
                        <label class="control-label">Description</label>
                        <input type="text" name="desc" class="form-control" value="<?php if (!empty($desc)) {
                           echo $desc;
                        } ?>">
                     </div>


                     <div class="col-md-12">
                        <?php if (isset($update_id)) { ?>
                           <input type="hidden" name="update_id" id="update_id" value="<?= $update_id; ?>">
                        <?php } ?>
                        <div class="d-md-flex d-grid align-items-center gap-3">
                           <button type="submit" class="btn btn-primary px-4">Save</button>
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