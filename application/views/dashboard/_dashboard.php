<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
      <!--breadcrumb-->
      <!--end breadcrumb-->
      <div class="row row-cols-1 row-cols-xl-4">
         <div class="col">
            <div class="card border-primary border-bottom rounded-4">
               <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between">
                     <p class="mb-0 fs-6">Total products</p>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mt-3">
                     <div class="">
                        <h4 class="mb-0 fw-bold">
                           <?= count($this->M_product->get_all_products()); ?>
                        </h4>
                        <div class="d-flex align-items-center justify-content-start gap-1 text-success mt-3">
                        </div>
                     </div>
                     <div id="chart1"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col">
            <div class="card border-warning border-bottom rounded-4">
               <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between">
                     <p class="mb-0 fs-6">Expiring products</p>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mt-3">
                     <div class="">
                        <h4 class="mb-0 fw-bold"> <?= count($this->M_product->get_expiring_products()); ?></h4>
                        <div class="d-flex align-items-center justify-content-start gap-1 text-success mt-3">
                        </div>
                     </div>
                     <div id="chart2"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col">
            <div class="card border-success border-bottom rounded-4">
               <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between">
                     <p class="mb-0 fs-6">New products</p>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mt-3">
                     <div class="">
                        <h4 class="mb-0 fw-bold"><?= count($this->M_product->get_new_products()); ?></h4>
                        <div class="d-flex align-items-center justify-content-start gap-1 text-success mt-3">
                        </div>
                     </div>
                     <div id="chart3"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col">
            <div class="card border-danger border-bottom rounded-4">
               <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between">
                     <p class="mb-0 fs-6">Expired products</p>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mt-3">
                     <div class="">
                        <h4 class="mb-0 fw-bold">
                           <?= count($this->M_product->get_expired_products()); ?>
                        </h4>
                        <div class="d-flex align-items-center justify-content-start gap-1 text-danger mt-3">
                        </div>
                     </div>
                     <div id="chart4"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="col">
         <div class="card border-warning border-bottom rounded-4">
            <div class="card-body">
               <div class="d-flex align-items-center justify-content-between">
                  <p class="mb-0 fs-6">Products Running Low</p>
               </div>
               <div class="d-flex align-items-center justify-content-between mt-3">
                  <div class="">
                     <h4 class="mb-0 fw-bold">
                        <?= count($this->M_product->get_products_running_low()); ?>
                     </h4>
                     <div class="d-flex align-items-center justify-content-start gap-1 text-danger mt-3">
                     </div>
                  </div>
                  <div id="chart4"></div>
               </div>
            </div>
         </div>
      </div>

      <div class="card border-danger border-bottom rounded-4">
         <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
               <p class="mb-0 fs-6">Depleted Products</p>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-3">
               <div class="">
                  <h4 class="mb-0 fw-bold">
                     <?= count($this->M_product->get_depleted_products()); ?>
                  </h4>
                  <div class="d-flex align-items-center justify-content-start gap-1 text-success mt-3">
                  </div>
               </div>
               <div id="chart4"></div>
            </div>
         </div>
      </div>
   </div>
   </div>
   <!--end row-->

   </div>
</main>
<!--end main wrapper-->
<?php $this->load->view('includes/footer.php'); ?>