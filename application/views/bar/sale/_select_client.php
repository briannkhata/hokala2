<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
      <div class="row">
         <div class="col-12 col-xl-12">
            <div class="card">
               <div class="card-body p-4">
                  <h5 class="mb-4">
                     <?= $page_title; ?>
                  </h5>
                  <?php if ($this->session->flashdata('message')) { ?>
                     <div class="alert alert-border-danger alert-dismissible fade show">
                        <div class="d-flex align-items-center">
                           <div class="font-35 text-danger"><span class="material-icons-outlined fs-2">check_circle</span>
                           </div>
                           <div class="ms-3">
                              <h6 class="mb-0 text-danger"><?= $this->session->flashdata('message'); ?></h6>
                           </div>
                        </div>
                     </div>
                  <?php } ?>
                  <hr>
          
                     <form class="row g-3" action="<?= base_url(); ?>Sale/save_client" method="post">         
                        <div class="col-md-12">
                           <select class="form-control" name="client_id" id="client_id">
                              <?php foreach ($this->M_client->get_clients() as $row) { ?>
                                 <option <?= $row['client_id'] == 1 ? 'selected' : ''; ?> value="<?= $row['client_id']; ?>">
                                    <?= $row['name']; ?> |
                                    <?= $row['phone']; ?>
                                 </option>
                              <?php } ?>
                           </select>
                           <?= form_error('client_id', '<div class="text-danger">', '</div>'); ?>
                        </div>

                        <fieldset>
                           <legend>If New</legend>
                           <hr>
                           <div class="col-md-6">
                              <label for="input1" class="form-label">Name</label>
                              <input type="text" name="name" class="form-control">
                           </div>
                           <div class="col-md-6">
                              <label for="input1" class="form-label">Phone</label>
                              <input type="text" name="phone" class="form-control">
                           </div>
                        </fieldset>
                        <div class="col-md-12">
                           <div class="d-md-flex d-grid align-items-center gap-3">
                              <button type="submit" class="btn btn-outline-primary">CONTINUE >></button>
                           </div>
                        </div>
                     </form>
                  </div>

               </div>
            </div>
         </div>
      </div>
   </div>
</main>

<?php $this->load->view('includes/footer.php'); ?>