<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
      <h6 class="mb-0 text-uppercase">
         <?= $page_title; ?>
      </h6>
      <hr>
      <div class="col">
         <div class="btn-group">
            <a href="<?= base_url(); ?>Category/read" class="btn btn-secondary">
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
                     <h6 class="mb-0 text-success"><?= $this->session->flashdata('message'); ?></h6>
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
                     <tr id="filters">
                        <th>Name</th>
                        <th>UN Code</th>
                        <th>Desc</th>
                        <th>Products</th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($this->M_category->get_categories() as $row) { ?>
                        <tr>
                           <td>
                              <?= $row['category']; ?>
                           </td>
                           <td>
                              <?= $row['un_code']; ?>
                           </td>
                           <td>
                              <?= $row['desc']; ?>
                           </td>
                           <td><?= count($this->M_product->get_products_by_category($row['category_id'])); ?></td>
                           <td>
                              <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                 <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle"
                                       data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                                    <ul class="dropdown-menu">
                                       <li>
                                          <a href="<?= base_url(); ?>Category/read/<?= $row['category_id']; ?>"
                                             class="dropdown-item">
                                             Edit
                                          </a>
                                       </li>
                                       <li>
                                          <a href="<?= base_url(); ?>Category/view/<?= $row['category_id']; ?>"
                                             class="dropdown-item">
                                             View Products
                                          </a>
                                       </li>
                                       <li>
                                          <a href="<?= base_url(); ?>Category/delete/<?= $row['category_id']; ?>"
                                             class="dropdown-item">
                                             Delete
                                          </a>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                           </td>
                        </tr>
                     <?php } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
</main>
<!--end main wrapper-->
<?php $this->load->view('includes/footer.php'); ?>