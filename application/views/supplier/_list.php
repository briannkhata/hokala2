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
            <a href="<?= base_url(); ?>Supplier/read" class="btn btn-secondary">
               Add New
            </a>
         </div>
      </div>
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
            <table id="example" class="table table-striped table-bordered" style="width:100%">
               <thead>
                  <tr>
                     <th>Name</th>
                     <th>Phone</th>
                     <th>Address</th>
                     <th></th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach ($this->M_supplier->get_suppliers() as $row) { ?>
                     <tr>
                        <td>
                           <?= $row['name']; ?>
                        </td>
                        <td>
                           <?= $row['phone']; ?>
                        </td>
                        <td>
                           <?= $row['address']; ?>
                        </td>
                        <td>
                           <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                              <div class="btn-group" role="group">
                                 <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">Action</button>
                                 <ul class="dropdown-menu">

                                    <li>
                                       <a href="<?= base_url(); ?>Supplier/read/<?= $row['supplier_id']; ?>"
                                          class="dropdown-item">
                                          Edit
                                       </a>
                                    </li>
                                    <li>
                                       <a href="<?= base_url(); ?>Supplier/delete/<?= $row['supplier_id']; ?>"
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