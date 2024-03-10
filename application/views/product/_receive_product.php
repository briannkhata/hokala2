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
                  <form action="<?= base_url(); ?>Product/save_receiving" class="row g-3" method="post">


                     <div class="col-md-12">
                        <label class="control-label">Search Product</label>
                        <select id="product_id" class="form-control" name="product_id" required="">
                           <option selected="" disabled="">----</option>
                           <?php foreach ($this->M_product->get_products() as $row) { ?>
                              <option value="<?= $row['product_id']; ?>">
                                 <?= $row['name']; ?> | <?= $row['desc']; ?> | CURRENT QTY :  <?= $row['qty']; ?>
                              </option>
                           <?php } ?>
                        </select>
                     </div>
                     <div class="col-md-4">
                        <label class="control-label">Qty</label>
                        <input type="text" name="qty" class="form-control">
                     </div>

                     <div class="col-md-4">
                        <label class="control-label">Cost Price</label>
                        <input type="text" name="cost_price" class="form-control">
                     </div>

                     <div class="col-md-4">
                        <label class="control-label">Selling Price</label>
                        <input type="text" name="selling_price" class="form-control">
                     </div>

                     <div class="col-md-6 ">
                        <label class="control-label">Expiry Date</label>
                        <input type="date" name="expiry_date" class="form-control">
                     </div>

                    

                     <div class="col-md-12">

                        <div class="d-md-flex d-grid align-items-center gap-3">
                           <button type="submit" class="btn btn-primary px-4">Receive</button>
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