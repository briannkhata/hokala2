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
                  <a href="#" data-bs-toggle="modal" data-bs-target="#assignUser" class="btn btn-secondary">Assign
                     User</a>
                  <a href="#" onclick="dispose(<?= $asset_id; ?>)" class="btn btn-secondary">Dispose</a>
                  <a href="#" data-bs-toggle="modal" data-bs-target="#revaluate" class="btn btn-secondary">Revalue</a>
                  <a href="#" data-bs-toggle="modal" data-bs-target="#addPhotos" class="btn btn-secondary"
                     class="btn btn-secondary">Add Photos</a>
               </div>
               <hr>
            </div>

            <div class="accordion accordion-flush" id="accordionFlushExample">
               <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingOne">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Asset Information
                     </button>
                  </h2>
                  <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                     data-bs-parent="#accordionFlushExample">
                     <div class="accordion-body">
                        <table id="examplee" class="table table-striped">
                           <?php foreach ($details as $row) { ?>
                              <tr>
                                 <th>Barcode</th>
                                 <td>
                                    <?= $row['barcode']; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Description</th>
                                 <td>
                                    <?= $row['name']; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Category</th>
                                 <td>
                                    <?= $this->M_category->get_category_name($row['category_id']); ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Cost Centre</th>
                                 <td>
                                    <?= $this->M_centre->get_centre($row['centre_id']); ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Department</th>
                                 <td>
                                    <?= $this->M_department->get_department_name($row['department_id']); ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Acquisition Date</th>
                                 <td>
                                    <?= date('d F Y', strtotime($row['purchase_date'])); ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Acquisition cost</th>
                                 <td>
                                    <?= number_format($row['cost_price'], 2); ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Manufacturer</th>
                                 <td>
                                    <?= $row['manufacturer']; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Model Number</th>
                                 <td>
                                    <?= $row['model']; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Serial Number</th>
                                 <td>
                                    <?= $row['serial_no']; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Registration Number</th>
                                 <td>
                                    <?= $row['reg_no']; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Chasis Number</th>
                                 <td>
                                    <?= $row['chasis_no']; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Engine Number</th>
                                 <td>
                                    <?= $row['engine_no']; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Useful Years</th>
                                 <td>
                                    <?= $row['life_span']; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Used Years</th>
                                 <td>
                                    <?= $row['no_years_elapsed']; ?>
                                 </td>
                              </tr>
                              <tr>
                                 <th>Remaining Years</th>
                                 <td>
                                    <?= $row['no_years_remaining']; ?>
                                 </td>
                              </tr>
                           <?php } ?>
                        </table>
                     </div>
                  </div>
               </div>

               <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingThreee">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseThreee" aria-expanded="false"
                        aria-controls="flush-collapseThree">
                        Revaluation History
                     </button>
                  </h2>
                  <div id="flush-collapseThreee" class="accordion-collapse collapse"
                     aria-labelledby="flush-headingThreee" data-bs-parent="#accordionFlushExample">
                     <div class="accordion-body">
                        <table id="examplee" class="table table-striped">
                           <thead>
                              <tr>
                                 <th>Revalued On</th>
                                 <th>New Cost</th>
                                 <th>Old Cost</th>
                                 <th>Difference</th>
                                 <th>Revalued By</th>
                                 <th>Posted On</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $count = 1;
                              foreach ($this->M_asset->get_revaluations_by_asset_id($asset_id) as $row): ?>
                                 <tr>
                                    <td>
                                       <?= date("d-M-y", strtotime($row['reval_date'])); ?>
                                    </td>
                                    <td>
                                       <?= number_format($row['new_cost'], 2); ?>
                                    </td>
                                    <td>
                                       <?= number_format($row['cur_cost'], 2); ?>
                                    </td>
                                    <td>
                                       <?= number_format($row['difference'], 2); ?>
                                    </td>
                                    <td>
                                       <?= $this->M_user->get_name($row['posted_by']); ?>
                                    </td>
                                    <td>
                                       <?= $row['posted_date']; ?>
                                    </td>
                                 </tr>
                              <?php endforeach; ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>

               <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingTwo">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Users
                     </button>
                  </h2>
                  <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                     data-bs-parent="#accordionFlushExample">
                     <div class="accordion-body">
                        <table id="examplee" class="table table-striped">
                           <thead>
                              <tr>
                                 <th style="width:4px">#</th>
                                 <th>Name</th>
                                 <th>Date Assigned</th>
                                 <th>Assigned By</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $count = 1;
                              foreach ($this->M_asset->get_asset_users($asset_id) as $row): ?>
                                 <tr>
                                    <td>
                                       <?= $count++; ?>
                                    </td>
                                    <td>
                                       <?= $this->M_user->get_name($row['user_id']) ?>
                                    </td>
                                    <td>
                                       <?= $row['date_assigned']; ?>
                                    </td>
                                    <td>
                                       <?= $this->M_user->get_name($row['assigned_by']) ?>
                                    </td>
                                 </tr>
                              <?php endforeach; ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingThree">
                     <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        Photos
                     </button>
                  </h2>
                  <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree"
                     data-bs-parent="#accordionFlushExample">
                     <div class="accordion-body">
                        <table id="examplee" class="table table-striped">
                           <thead>
                              <tr>
                                 <th>Photo</th>
                                 <th>Added by</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              $count = 1;
                              foreach ($this->M_asset->get_asset_photos($asset_id) as $row): ?>
                                 <tr>
                                    <td>
                                       <?php
                                       $imagePath = base_url('uploads/assets/' . $row['photo']);
                                       ?>
                                       <img src="<?= $imagePath ?>" alt="Asset Photo" class="img-responsive">
                                    </td>
                                    <td>
                                       <?= $this->M_user->get_name($row['added_by']) ?>
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
      </div>


   </div>
   </div>
</main>
<!--end main wrapper-->
<?php $this->load->view('includes/footer.php'); ?>
<div class="col">
   <div class="modal fade" id="assignUser" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Assign Asset To User</h5>
            </div>
            <div class="modal-body">
               <form class="row g-3" method="post" id="assignuserForm" enctype='multipart/form-data'>
                  <select id="user_id" class="form-control" name="user_id">
                     <option selected="" disabled="">Select user</option>
                     <?php foreach ($this->M_user->get_users() as $row) { ?>
                        <option value="<?= $row['user_id']; ?>">
                           <?= $row['emp_no']; ?> |
                           <?= $row['firstname']; ?>
                           <?= $row['surname']; ?>
                        </option>
                     <?php } ?>
                  </select>
                  <input type="hidden" id="asset_id" name="asset_id" value="<?= $asset_id; ?>">
               </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary" onclick="assign_asset_to_user()">Assign</button>
            </div>
         </div>
      </div>
   </div>
</div>
<form action="<?= base_url(); ?>Asset/add_asset_photos" class="row g-3" method="post" id="addPhotoForm"
   enctype='multipart/form-data'>
   <div class="col">
      <div class="modal fade" id="addPhotos" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Add Asset Photos</h5>
               </div>
               <div class="modal-body">
                  <input type="file" name="photo[]" multiple class="form-control">
                  <input type="hidden" id="asset_id" name="asset_id" value="<?= $asset_id; ?>">
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Add Photo</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>
<form action="<?= base_url(); ?>Asset/revaluate" class="row g-3" method="post" id="revaluateForm">
   <div class="col">
      <div class="modal fade" id="revaluate" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Re-valuate Asset</h5>
               </div>
               <div class="modal-body">
                  <div class="col-md-12">
                     <label class="control-label">Barcode</label>
                     <input type="text" class="form-control" value="<?= $this->M_asset->get_barcode($asset_id); ?>"
                        readonly="">
                  </div>
                  <br>

                  <div class="col-md-12">
                     <label class="control-label">Old Cost</label>
                     <input type="text" id="old_cost_price" name="old_cost_price" class="form-control"
                        value="<?= number_format($this->M_asset->get_cost_price($asset_id), 2); ?>" readonly>
                  </div>
                  <br>

                  <div class="col-md-12">
                     <label class="control-label">Accum Dep</label>
                     <input type="text" name="cur_accum_dep" id="cur_accum_dep" class="form-control"
                        value="<?= number_format($this->M_asset->get_asset_accumulated_depreciation($asset_id), 2); ?>"
                        readonly>
                  </div>
                  <br>

                  <div class="col-md-12">
                     <label class="control-label">NBV</label>
                     <input type="text" name="nbv" id="nbv" class="form-control"
                        value="<?= number_format($this->M_asset->get_net_book_value($asset_id), 2); ?>" readonly>
                  </div>
                  <br>

                  <div class="col-md-12">
                     <label class="control-label">New Cost</label>
                     <input type="text" id="new_cost_price" name="new_cost_price" class="form-control" value=""
                        required="">
                  </div>
                  <br>
                  <div class="col-md-12">
                     <label class="control-label">Revalued Date</label>
                     <input type="date" name="reval_date" class="form-control" value="" required />
                  </div>
                  <br>
                  <div class="col-md-12">
                     <label class="control-label">Useful Years</label>
                     <input type="text" id="life_span" name="life_span" class="form-control"
                        value="<?= $this->M_asset->get_life_span($asset_id); ?>">
                  </div>
                  <input type="hidden" id="asset_id" name="asset_id" value="<?= $asset_id; ?>">
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Revalue</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>
<script>
   function dispose(asset_id) {
      var confirmed = confirm("Are you sure you want to dispose of this asset?");
      if (!confirmed) {
         return; // Do nothing if user cancels the action
      }

      $.ajax({
         url: '<?= base_url(); ?>Asset/dispose_request/' + asset_id,
         type: 'POST',
         data: {
            asset_id: asset_id
         },
         dataType: 'json',
         beforeSend: function () {
            $('#loader').show();
            $('#overlay').show();
         },
         success: function (data) {
            $('#loader').hide();
            $('#overlay').hide();
            location.reload();
            alert(data.message);
         },
         error: function () {
            console.log('Error saving data.');
         },
         complete: function () {
            $('#loader').hide();
            $('#overlay').hide();
            //alert(data.message);
         }
      });
   }

   function assign_asset_to_user() {
      var formData = $('#addPhotoForm').serialize();
      $.ajax({
         url: '<?= base_url(); ?>Asset/assign_asset_to_user',
         type: 'POST',
         data: formData,
         dataType: 'json',
         beforeSend: function () {
            $('#loader').show();
            $('#overlay').show();
         },
         success: function (data) {
            $('#loader').hide();
            $('#overlay').hide();
            location.reload();
            $('#assignUser').modal('hide');
            alert(data.message);
         },
         error: function () {
            console.log('Error saving data.');
         },
         complete: function () {
            $('#loader').hide();
            $('#overlay').hide();
            $('#assignUser').modal('hide');
            //alert(data.message);
         }
      });
   }


   function add_asset_photos() {
      var formData = $('#addPhotoForm').serialize();
      $.ajax({
         url: '<?= base_url(); ?>Asset/add_asset_photos',
         type: 'POST',
         data: formData,
         dataType: 'json',
         beforeSend: function () {
            $('#loader').show();
            $('#overlay').show();
         },
         success: function (data) {
            $('#loader').hide();
            $('#overlay').hide();
            location.reload();
            alert(data.message);
         },
         error: function () {
            console.log('Error saving data.');
         },
         complete: function () {
            $('#loader').hide();
            $('#overlay').hide();
            //alert(data.message);
         }
      });
   }

</script>