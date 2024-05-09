<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<main class="main-wrapper">
   <div class="main-content">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title">
               <?= $page_title; ?>
            </h5>
            <hr>
            <div class="col">
               <div class="btn-group">

                  <a href="<?= base_url(); ?>Product/read" class="btn btn-secondary">
                     Add New
                  </a>

               </div>

            </div>
            <hr>
            <div class="col" style="margin-top:2%;">
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
            </div>
            <div class="card">
               <div class="card-body">
                  <div class="table-responsive">

                     <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                           <tr>
                              <th>Barcode</th>
                              <th>Product</th>
                              <th>Description</th>
                              <th>Selling Price</th>
                              <th>Reorder Level</th>
                              <th>Unit</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $count = 1;
                           foreach ($this->M_product->get_products() as $row): ?>
                              <tr>

                                 <td>
                                    <?= $row['barcode'] ?>
                                 </td>
                                 <td>
                                    <?= $row['name'] ?>
                                 </td>
                                 <td>
                                    <?= $row['desc'] ?>
                                 </td>
                                
                                 <td>
                                    <?= number_format($row['selling_price'], 2) ?>
                                 </td>

                                 <td>
                                    <?= $row['reorder_level']; ?>
                                 </td>
                                 <td>
                                 <?= $this->M_unit->get_unit_type($row['unit_id']) ?>
                                 </td>
                                 <td>
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                       <div class="btn-group" role="group">
                                          <button type="button" class="btn btn-secondary dropdown-toggle"
                                             data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                                          <ul class="dropdown-menu">

                                             <li>
                                                <a href="<?= base_url(); ?>Product/read/<?= $row['product_id']; ?>"
                                                   class="dropdown-item">
                                                   Edit
                                                </a>
                                             </li>

                                             <li>
                                                <a href="<?= base_url(); ?>Product/view/<?= $row['product_id']; ?>"
                                                   class="dropdown-item">
                                                   View
                                                </a>
                                             </li>

                                             <li>
                                                <a href="<?= base_url(); ?>Product/delete/<?= $row['product_id']; ?>"
                                                   class="dropdown-item">
                                                   Delete
                                                </a>
                                             </li>


                                          </ul>
                                       </div>
                                    </div>
                                 </td>
                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                     </table>

                  </div>
               </div>
            </div>

</main>

<?php $this->load->view('includes/footer.php'); ?>
<script>
   $('#searchButton').on('click', function () {
      performSearch();
   });

   // Search functionality on input change
   $('#searchInput').on('input', function () {
      performSearch();
   });

   function performSearch() {
      var searchValue = $('#searchInput').val().toLowerCase();
      $('table tbody tr').each(function () {
         var text = $(this).text().toLowerCase();
         $(this).toggle(text.indexOf(searchValue) !== -1);
      });
   }
</script>