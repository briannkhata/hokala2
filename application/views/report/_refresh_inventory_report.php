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
                  <a href="#" class="btn btn-secondary">
                     Print
                  </a>
               </div>
            </div>


         </div>
         <div class="card">
            <div class="card-body">
               <div class="table-responsive">

                  <table id="examplee" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                        <tr>
                           <th>Barcode</th>
                           <th>Product</th>
                           <th>Description</th>
                           <th>Category</th>
                           <th>Selling Price</th>
                           <th>Reorder Level</th>
                           <th>Quantity</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
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
                                 <?= $this->M_category->get_category_name($row['category_id']) ?>
                              </td>

                              <td>
                                 <?= number_format($row['selling_price'], 2) ?>
                              </td>
                              <td>
                                 <?= $row['reorder_level']; ?>
                              </td>
                              <td>
                                 <?= $row['qty']; ?>
                              </td>

                           </tr>
                        <?php endforeach; ?>
                     </tbody>
                  </table>

               </div>
            </div>
         </div>
      </div>
   </div>


</main>

<?php $this->load->view('includes/footer.php'); ?>