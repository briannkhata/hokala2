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
                  <h5 class="mb-4"><?=$page_title;?></h5>
                  <hr>
                  <form class="row g-3" action="<?=base_url();?>Report/quarter_dep_expense" method="post">
                     <div class="col-md-4">
                        <select class="form-control" name="quarter" required="">
                           <option selected="" disabled="">--SELECT QUARTER--</option>
                           <option <?php echo ($quarter_number == 1) ? 'selected' : '' ?> value='1'>1st Quarter</option>
                           <option <?php echo ($quarter_number == 2) ? 'selected' : '' ?> value='2'>2nd Quarter</option>
                           <option <?php echo ($quarter_number == 3) ? 'selected' : '' ?> value='3'>3rd Quarter</option>
                           <option <?php echo ($quarter_number == 4) ? 'selected' : '' ?> value='4'>4th Quarter</option>
                        </select>
                     </div>
                     <div class="col-md-4">
                        <select class="form-control" name="year" required="">
                           <option selected="" disabled="">--SELECT YEAR--</option>
                           <?php 
                              for ($i = 2020 ; $i <= date('Y'); $i++){   
                              //echo "<option>$i</option>";
                              echo '<option value="'.$i.'"';
                                  if($i == date('Y') ){
                                      echo 'selected = "selected"';
                                  }
                                      echo ' >'.$i.'</option>';      
                                }
                              ?>
                        </select>
                        <br />
                     </div>
                     <div class="col-md-4">
                        <select id="centre_search" class="form-control" name="centre_id" required="">
                           <option disabled="">::SELECT CENTRE::</option>
                           <option selected="" value="0">All</option>
                           <?php foreach($this->M_centre->get_centres() as $row){?>
                           <option value ="<?=$row['centre_id'];?>"><?=$row['centre_name'];?></option>
                           <?php }?>
                        </select>
                     </div>
                     <div class="col-md-12"><button type="submit" class="btn btn-secondary">View Report</button></div>
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