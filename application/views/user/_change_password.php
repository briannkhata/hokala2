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
                  <?php if ($this->session->flashdata('message')) { ?>
                  <div class="alert alert-border-success alert-dismissible fade show">
                     <div class="d-flex align-items-center">
                        <div class="font-35 text-success"><span class="material-icons-outlined fs-2">check_circle</span>
                        </div>
                        <div class="ms-3">
                           <h6 class="mb-0 text-success"><?=$this->session->flashdata('message'); ?></h6>
                        </div>
                     </div>
                  </div>
                  <?php } ?> 
                  <hr>
                  <form action="<?=base_url();?>User/save_password_change" class="row g-3" method="post">

                        <div class="col-md-12">
                           <label class="control-label">New Password</label>
                           <div class="input-group">
                            <input type="password" name="password" class="form-control" id="passwordInput">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <input type="checkbox" onclick="togglePassword()"> Show
                                </div>
                            </div>
                        </div>
                        </div>
                    
                     <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                           <button type="submit" class="btn btn-primary px-4">Change Password</button>
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
<script>
    function togglePassword() {
        var passwordInput = document.getElementById("passwordInput");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
</script>
<?php $this->load->view('includes/footer.php'); ?>

