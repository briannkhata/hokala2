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
                  <form action="<?= base_url(); ?>Config/save" id="form" class="row g-3" method="post"
                     enctype='multipart/form-data'>
                     <?php foreach ($this->db->get('tbl_settings')->result_array() as $row) { ?>

                        <div class="col-md-12">
                           <label class="control-label">Logo</label>
                           <input type="file" name="logo" id="logo" class="form-control">
                        </div>
                       
                        <img id="image" src="<?=$row['logo']; ?>"
                           class="img-responsive img-thumbnail"
                           style="width: 250px; height: 250px; margin-left: 3%; margin-top: 1%;" />

                        <div class="col-md-12">
                           <label class="control-label">Shop</label>
                           <input type="hidden" name="id" class="form-control" value="<?= $row['id']; ?>">
                           <input type="text" name="company" class="form-control" value="<?= $row['company']; ?>" required>
                        </div>


                        <div class="col-md-6">
                           <label class="control-label">Phone</label>
                           <input type="text" name="phone" class="form-control" value="<?= $row['phone']; ?>">
                        </div>

                        <div class="col-md-6">
                           <label class="control-label">Alt Phone</label>
                           <input type="text" name="alt_phone" class="form-control" value="<?= $row['alt_phone']; ?>">
                        </div>

                        <div class="col-md-6">
                           <label class="control-label">Email</label>
                           <input type="text" name="email" class="form-control" value="<?= $row['email']; ?>">
                        </div>

                        <div class="col-md-6">
                           <label class="control-label">Alt Email</label>
                           <input type="text" name="alt_email" class="form-control" value="<?= $row['alt_email']; ?>">
                        </div>

                        <div class="col-md-12">
                           <label class="control-label">Address</label>
                           <textarea name="address" class="form-control"><?= $row['address']; ?></textarea>
                        </div>

                        <div class="col-md-12">
                           <label class="control-label">VAT</label>
                           <input type="text" name="vat" class="form-control" value="<?= $row['vat']; ?>">
                        </div>

                        <div class="col-md-12">
                           <label class="control-label">VAT Status</label>
                           <select class="form-control" name="vat_status">
                              <option selected disabled>option</option>
                              <option <?php if ($row['vat_status'] == "inclusive")
                                 echo 'selected'; ?> value="inclusive">
                                 Inclusive</option>
                              <option <?php if ($row['vat_status'] == "exclusive")
                                 echo 'selected'; ?> value="exclusive">
                                 Exclusive</option>
                              <option <?php if ($row['vat_status'] == "exclude")
                                 echo 'selected'; ?> value="exclude">Exclude
                              </option>
                           </select>
                        </div>

                        <div class="col-md-12">
                           <div class="d-md-flex d-grid align-items-center gap-3">
                              <button type="submit" class="btn btn-primary px-4">Save</button>
                           </div>
                        </div>
                     <?php } ?>
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
   // function previewImage(input) {
   //    var file = input.files[0];

   //    if (file) {
   //       var reader = new FileReader();
   //       reader.onload = function (e) {
   //          $('#photoPreview').html('<img src="' + e.target.result + '" class="img-fluid" alt="Preview" style="width:150px; height:100px;">');
   //       }

   //       reader.readAsDataURL(file);
   //    }
   // }

   document.getElementById("logo").onchange = function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("image").src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    };

</script>
<?php $this->load->view('includes/footer.php'); ?>