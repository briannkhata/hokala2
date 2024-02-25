<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
   <h6 class="mb-0 text-uppercase"><?= $page_title; ?></h6>
   <hr>
   <div class="col">
      <div class="btn-group">
         <a href="#" class="btn btn-secondary">Excel</a>
         <a href="#" class="btn btn-secondary">Print</a>
      </div>
   </div>
   <div class="col" style="margin-top:2%;">
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
   </div>

            <table id="examplee" class="table table-striped table-bordered" style="width:100%">
               <thead>
                  <tr>
                     <th>Barcode</th>
                     <th>Description</th>
                     <th>Category</th>
                     <th>Cost Centre</th>
                     <th>Revalued On</th>
                     <th>New Cost</th>
                     <th>Old Cost</th>
                     <th>Difference</th>
                     <th>Revalued By</th>
                     <th>Posted On</th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach ($fetch_data as $row): ?>
                  <tr>
                     <td><?= $row['barcode']; ?></td>
                     <td><?= $row['name']; ?></td>
                     <td><?= $this->M_category->get_category_name($row['category_id']) ?></td>
                     <td><?= $this->M_centre->get_centre($row['centre_id']) ?></td>
                     <td><?= date("d-M-y", strtotime($row['reval_date'])); ?></td>
                     <td><?= number_format($row['new_cost'],2); ?></td>
                     <td><?= number_format($row['cur_cost'],2); ?></td>
                     <td><?= number_format($row['difference'],2); ?></td>
                     <td><?= $this->M_user->get_name($row['posted_by']); ?></td>
                     <td><?= $row['posted_date']; ?></td>
                  </tr>
                  <?php endforeach; ?>
               </tbody>
               </tbody>
            </table>
       
</main>
<!--end main wrapper-->
<?php $this->load->view('includes/footer.php'); ?>