<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
      <!--breadcrumb-->
      <!--end breadcrumb-->
      <div class="card">
         <div class="card-body">
            <h5 class="card-title">
               <?= $page_title; ?>
            </h5>
            <hr>
            <div class="col">
               <div class="btn-group">
                  <a href="<?= base_url(); ?>User/read" class="btn btn-secondary">
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
            <hr>
            <div class="card">


               <table id="example" class="table table-striped table-bordered" style="width:100%">
                  <thead>
                     <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($this->M_user->get_users() as $row): ?>
                        <tr>
                         
                           <td>
                              <?= $row['name'] ?>
                           </td>

                           <td>
                              <?= $row['phone'] ?>
                           </td>
                           <td>
                              <?= $row['username'] ?>
                           </td>
                           <td>
                              <?= $row['role'] ?>
                           </td>

                           <td>
                              <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                 <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle"
                                       data-bs-toggle="dropdown" aria-expanded="false">Action</button>
                                    <ul class="dropdown-menu">
                                       <li>
                                          <a href="<?= base_url(); ?>User/read/<?= $row['user_id']; ?>"
                                             class="dropdown-item">
                                             Edit
                                          </a>
                                       </li>
                                       <li>
                                          <a href="<?= base_url(); ?>User/delete/<?= $row['user_id']; ?>"
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
<!--end main wrapper-->
<!--start overlay-->
<!--end overlay-->
<?php $this->load->view('includes/footer.php'); ?>