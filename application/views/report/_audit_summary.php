<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view('incs/header.php'); ?>
<?php $this->load->view('incs/menu.php'); ?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Audit Report</h3>
                </div>
            </div>
            <!-- ...content ... -->
            <div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Audit Report</h3>
				</div>
  				<div class="panel-body">
  					 <!-- ... form ... -->
                         <div class="col-lg-12">
                         <table class="table" id="AuditReport">
            <caption style="text-align:center; font-size: 20px;">
            <?php echo $title . " (" . date('d-M-y', strtotime($start_date)) . " to " . date('d-M-y', strtotime($end_date)) . ")"; ?>
            </caption>
            <thead>
            <tr>
            <th>Audit No</th>
                <th>Name of Project</th>
                <th>Total No. of Assets</th>
                <th>Assets Audited</th>
                <th>Missing / Unverified</th>
                <th>Date Audited</th>
                <th>Audited By</th>
            </tr>
        </thead>
            <?php //var_dump($audits); ?>
            <?php foreach($audits as $row){?>
        <tr> 
            <td><?=$row['auditID']; ?></td>
            <td><?=$this->report_model->get_audit_cost_centre($row['centre_ID']);?></td>
            <?php 
            //$total = 0;
            //check if assets have been disposed after audit start date
            //Add those assets disposed after audit start date bcoz they were available by time of audit
            $centre_disposed_assets_afta_audit = $this->report_model->count_audit_centre_disposed_assets_afta_audit_start_date($row['centre_ID'],$start_date);
            $centre_non_disposed_assets = $this->report_model->count_audit_centre_total_assets($row['centre_ID']);
            //add disposed + non disposed
            $centre_total_assets = $centre_disposed_assets_afta_audit + $centre_non_disposed_assets;
            $centre_total_audited = $this->report_model->count_centre_total_audited_assets($start_date,$end_date,$row['centre_ID'],$row['auditID']);
            //$centre_total_missing_assets = $this->report_model->count_audit_centre_missing_assets($row['centre_ID']);
            $centre_total_missing_assets = $centre_total_assets - $centre_total_audited;
            //$total += $centre_total_missing_assets;
            ?>
            <td><?=number_format($centre_total_assets);?></td>
            <td><?=number_format($centre_total_audited);?></td>
            <td><?=number_format($centre_total_missing_assets);?></td>
            <td><?= date('d-M-Y', strtotime($row['audit_date']));?></td>
            <td><?=$this->report_model->get_audit_user_name($row['user_ID']);?></td>
        </tr>
        <?php }?>
        <!--<tr>
            <td colspan="4">Total</td>
            <td><?//=number_format($total);?></td>
            </tr>-->
</table>
<button class="btn btn-primary export-btn"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
        <script>
  $(document).ready(function(){
    $(".export-btn").click(function(){
        $("#AuditReport").tableHTMLExport({
            type:'csv',
            filename:'<?php echo $title . " (" . date('d-M-y', strtotime($start_date)) . " to " . date('d-M-y', strtotime($end_date)) . ")"; ?>.csv',
            });
    });
  
  });
  </script>
<div class="col-lg-12">

</div>
                </div>      
  				</div>
  			</div> <!--end form-->
        </div>
    </div>
</div>
<?php $this->load->view('incs/footer.php'); ?>

