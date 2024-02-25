<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view('incs/header.php'); ?>
<?php $this->load->view('incs/menu.php'); ?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Run Annual Expense Summary</h3>
                </div>
            </div>
            <!-- ...content ... -->
            <div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Annual Expense Report</h3>
				</div>
  				<div class="panel-body">
  					 <!-- ... form ... -->
                       <!--<form role="form" class="form-vertical adminex-form" action="" method="post">-->
                       <form role="form" class="form-vertical adminex-form" action="<?=base_url('report/annual_dep_expense_ajax');?>" method="post">
                         <div class="col-lg-12">
                         <div class="col-lg-4">
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
                        <div class="col-lg-3">
                            <select id="centre_search" class="form-control" name="cost_centre" required="">
                                <option disabled="">::SELECT CENTRE::</option>
                                <option selected="" value="0">All</option>
                                <?php foreach($this->report_model->get_asset_cost_centres() as $row){?>
                              <option value ="<?=$row['centreID'];?>"><?=$row['centre_name'];?></option>
                                <?php }?>
                        </select>
                        </div> 
                        <div class="col-lg-2">
                        
                        </div>       
                              <div class="col-lg-12"><button type="submit" class="btn btn-default">View Report</button></div>
                         </div>
                </form>
  				</div>
  			</div> <!--end form-->
        </div>
    </div>
</div>
<?php $this->load->view('incs/footer.php'); ?>
