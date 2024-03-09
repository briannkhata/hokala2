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
                  <form action="<?= base_url(); ?>User/save" id="form" class="row g-3" method="post"
                     enctype='multipart/form-data'>


                     <div class="col-md-12">
                        <label class="control-label">Name</label>
                        <input type="text" name="name" class="form-control" value="<?php if (!empty($name)) {
                           echo $name;
                        } ?>">
                     </div>

                     <div class="col-md-6 ">
                        <label class="control-label">Phone</label>
                        <input type="tel" name="phone" class="form-control" value="<?php if (!empty($phone)) {
                           echo $phone;
                        } ?>">
                     </div>
                     <div class="col-md-6 ">
                        <label class="control-label">Role</label>
                        <select id="gender" name="role" class="form-control">
                           <option selected disabled> Role</option>
                           <option <?php if ($role == '0')
                              echo 'selected'; ?> value="0">Admin</option>
                           <option <?php if ($role == '1')
                              echo 'selected'; ?> value="1">Cashier</option>
                        </select>
                     </div>

                     <div class="col-md-6">
                        <label class="control-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?php if (!empty($username)) {
                           echo $username;
                        } ?>">
                     </div>
                     <div class="col-md-6">
                        <label class="control-label">Password</label>
                        <input type="password" name="password" class="form-control" value="<?php if (!empty($password)) {
                           echo $password;
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
<script type="text/javascript">
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
</script>
<?php $this->load->view('includes/footer.php'); ?>