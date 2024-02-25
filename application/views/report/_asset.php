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
                  <form class="row g-3" action="<?= base_url(); ?>Report/asset_filter" method="POST">
                     <div class="col-md-3">
                        <label for="input1" class="form-label">New</label>
                        <input type="checkbox" name="new" class="form-check-input">
                     </div>
                     <div class="col-md-3">
                        <label for="missing" class="form-label">Missing</label>
                        <input type="checkbox" id="missing" name="missing" class="form-check-input">
                     </div>
                     <div class="col-md-3">
                        <label for="input1" class="form-label">Deleted</label>
                        <input type="checkbox" name="deleted" class="form-check-input">
                     </div>
                     <div class="col-md-6">
                        <label for="input1" class="form-label">Centre</label>
                        <select class="form-control" name="centre_id">
                           <option selected disabled>Select Option</option>
                           <?php foreach ($this->M_centre->get_centres() as $row) { ?>
                              <option value="<?= $row['centre_id']; ?>">
                                 <?= $row['centre_name']; ?>
                              </option>

                           <?php } ?>
                        </select>
                     </div>

                     <div class="col-md-6">
                        <label for="input1" class="form-label">Department</label>
                        <select class="form-control" name="department_id">
                           <option selected disabled>Select Option</option>
                           <?php foreach ($this->M_department->get_departments() as $row) { ?>
                              <option value="<?= $row['department_id']; ?>">
                                 <?= $row['department_name']; ?>
                              </option>

                           <?php } ?>
                        </select>
                     </div>

                     <div class="col-md-6">
                        <label for="input1" class="form-label">Category</label>
                        <select class="form-control" name="category_id">
                           <option selected disabled>Select Option</option>
                           <?php foreach ($this->M_category->get_categories() as $row) { ?>
                              <option value="<?= $row['category_id']; ?>">
                                 <?= $row['category_name']; ?>
                              </option>

                           <?php } ?>
                        </select>
                     </div>

                     <div class="col-md-6">
                        <label for="input1" class="form-label">Donor</label>
                        <select class="form-control" name="donor_id">
                           <option selected disabled>Select Option</option>
                           <?php foreach ($this->M_donor->get_donors() as $row) { ?>
                              <option value="<?= $row['donor_id']; ?>">
                                 <?= $row['donor_name']; ?>
                              </option>

                           <?php } ?>
                        </select>
                     </div>


                     <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                           <button type="submit" class="btn btn-primary px-4">View Report</button>
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