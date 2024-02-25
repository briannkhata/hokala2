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
                  <form action="<?= base_url(); ?>Product/save" class="row g-3" method="post">

                     <div class="col-md-6">
                        <label class="control-label">Barcode</label>
                        <input type="text" name="barcode" class="form-control"
                           value="<?php if (!empty($barcode)) {
                              echo $barcode;
                           } ?>">
                     </div>
                     <div class="col-md-6">
                        <label class="control-label">Product Name</label>
                        <input type="text" name="name" class="form-control"
                           value="<?php if (!empty($name)) {
                              echo $name;
                           } ?>" required="">
                     </div>
                     <div class="col-md-12">
                        <label class="control-label">Description</label>
                        <input type="text" name="desc" class="form-control"
                           value="<?php if (!empty($desc)) {
                              echo $desc;
                           } ?>" required="">
                     </div>
                     <div class="col-md-6">
                        <label class="control-label">Selling Price</label>
                        <input type="text" name="selling_price" class="form-control"
                           value="<?php if (!empty($selling_price)) {
                              echo $selling_price;
                           } ?>">
                     </div>
                     <div class="col-md-6">
                        <label class="control-label">Cost Price</label>
                        <input type="text" name="cost_price" class="form-control"
                           value="<?php if (!empty($cost_price)) {
                              echo $cost_price;
                           } ?>">
                     </div>


                     <div class="col-md-4">
                        <label class="control-label">Category</label>
                        <select id="cat_search" class="form-control" name="category_id" required="">
                           <option selected="" disabled="">----</option>
                           <?php foreach ($this->M_category->get_categories() as $row) { ?>
                              <option <?php if ($category_id == $row['category_id'])
                                 echo 'selected'; ?>
                                 value="<?= $row['category_id']; ?>">
                                 <?= $row['category']; ?>
                              </option>
                           <?php } ?>
                        </select>
                     </div>

                     <div class="col-md-4">
                        <label class="control-label">Supplier</label>
                        <select class="form-control" name="supplier_id" required="">
                           <option selected="" disabled="">----</option>
                           <?php foreach ($this->M_supplier->get_suppliers() as $row) { ?>
                              <option <?php if ($supplier_id == $row['supplier_id'])
                                 echo 'selected'; ?>
                                 value="<?= $row['supplier_id']; ?>">
                                 <?= $row['name']; ?>
                              </option>
                           <?php } ?>
                        </select>
                     </div>


                     <div class="col-md-4 ">
                        <label class="control-label">Expiry Date</label>
                        <input type="date" name="expiry_date" class="form-control"
                           value="<?php if (!empty($expiry_date)) {
                              echo $expiry_date;
                           } ?>">
                     </div>

                     <div class="col-md-6">
                        <label class="control-label">Reorder Level In Days</label>
                        <input type="text" name="reorder_level" class="form-control"
                           value="<?php if (!empty($reorder_level)) {
                              echo $reorder_level;
                           } ?>">
                     </div>

                     <div class="col-md-6">
                        <label class="control-label">Qty</label>
                        <input type="text" name="qty" class="form-control"
                           value="<?php if (!empty($qty)) {
                              echo $qty;
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