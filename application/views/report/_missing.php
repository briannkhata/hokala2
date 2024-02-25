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
               
                  <hr>
                  <form class="row g-3" action="<?= base_url(); ?>Report/refresh_missing" method="POST">
                
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