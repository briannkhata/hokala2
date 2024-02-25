<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view('incs/header.php'); ?>
<?php $this->load->view('incs/menu.php'); ?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Run Audit Summary</h3>
                </div>
            </div>
            <!-- ...content ... -->
            <div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Audit Report</h3>
				</div>
  				<div class="panel-body">
  					 <!-- ... form ... -->
                       <!--<form role="form" class="form-vertical adminex-form" action="" method="post">-->
                       <form role="form" class="form-vertical adminex-form" action="<?=base_url('report/audit_summary');?>" method="post">
                         <div class="col-lg-12">
                         <div class="col-lg-3">
                         <label class="control-label">From</label>
                           <div class="input-group date">
                            <input type="text" name = "from_date" class="form-control dtPicker" value=""  required/>
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            </span>
                        </div>
                        </div>
                         <div class="col-lg-3">
                         <label class="control-label">To</label>
                           <div class="input-group date">
                            <input type="text" name = "to_date" class="form-control dtPicker" value=""  required/>
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            </span>
                        </div>
                            <br />
                        </div>      
                        <div class="col-lg-3">
                            
                        </div> 
                        <div class="col-lg-3">
                        
                        </div>       
                              <div class="col-lg-12"><button type="submit" class="btn btn-primary">View Report</button></div>
                         </div>
                </form>
  				</div>
  			</div> <!--end form-->
        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
  $('.dtPicker').datetimepicker({
    //format: 'L',
    allowInputToggle: true,
    showClose: true,
    showClear: true,
    showTodayButton: true,
    format: "DD-MM-YYYY",
    ignoreReadonly: false,
  });
});
</script>
<?php $this->load->view('incs/footer.php'); ?>
