<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view('incs/header_dt.php'); ?>
<?php $this->load->view('incs/menu.php'); ?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><?php echo $quarter_name." (".date('d-M-y', strtotime($start_date))." to ".date('d-M-y', strtotime($end_date)).")"." Depreciation Expense";?></h3>
                </div>
            </div>
            <!-- ... Your content goes here ... -->
                  <!-- ... register ... -->
                  <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                Assets
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="table-responsive">
                                    <?php if ($this->session->flashdata('message')) { ?>
                                        <div class="alert alert-success fade in">
                                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                                        <center><?=$this->session->flashdata('Message'); ?> </center>
                                        </div>
                                    <?php } ?>  
                                        <table class="table table-striped table-bordered table-hover" id="dtTable">
                                            <thead>
                                                <tr>
                                                    <th>Barcode</th>
                                                    <th>Description</th>
                                                    <th>Category</th>
                                                    <th>Centre</th>
                                                    <th>Cost</th>
                                                    <th>Annual Dep</th>
                                                    <th>Quarter Dep</th>
                                                    <th>Accum Dep</th>
                                                    <th>NBV <?php echo date('d-M-y', strtotime($start_date)); ?></th> 
                                                    <th>NBV <?php echo date('d-M-y', strtotime($end_date)); ?></th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                    //$count = 1;
                                    foreach($this->report_model->get_assets() as $row){?>
                                    <tr>
                                        <td><?=$row['asset_barcode'];?></td>
                                        <td><?=$row['asset_name'];?></td>
                                        <td><?=$this->report_model->get_asset_category_name($row['asset_category']);?></td>
                                        <td><?=$this->report_model->get_asset_centre_name($row['asset_costcentre']);?></td>
                                        <td><?=number_format($row['asset_costprice'],2);?></td>
                                        <?php 
                                        //calculations
                                        $dep_percentage =  $this->report_model->get_cat_dep_rate($row['asset_category']);
                                        $dep_rate_in_decimal = $dep_percentage / 100;
                                        //annual dep
                                        $year_dep = $row['asset_costprice'] * $dep_rate_in_decimal;
                                        //Monthly dep when calculating using 360 days and 30 days in a month
                                        $month_dep = $row['asset_costprice'] * $dep_rate_in_decimal / 12;
                                        //quarter dep
                                        $quarter_charge = $month_dep * 3;
                                        //$quarter_accum_dep = $quarter_charge * $quarter_number;
                                        $accum_dep_from_last_quarter = $this->report_model->get_asset_quarter_accum_dep($row['assetID'],$start_date);
                                        ?>
                                        <td><?=number_format($year_dep,2);?></td>
                                        <td><?=number_format($quarter_charge,2);?></td>
                                        <td><?=number_format($accum_dep_from_last_quarter,2);?></td>
                                        <?php 
                                        //calc NBV
                                        $cost = $row['asset_costprice'];
                                       //total accum dep
                                       $total_dep = $quarter_charge + $accum_dep_from_last_quarter;
                                       //NBV
                                        $first_quarter_day_nbv = $cost - $accum_dep_from_last_quarter;
                                        $last_quarter_day_nbv = $cost - $total_dep;
                                        ?>
                                        <td><?=number_format($first_quarter_day_nbv,2);?></td>

                                        <td><?=number_format($last_quarter_day_nbv,2);?></td>
                                    </tr>
                                        <?php }?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
        </div>
    </div>
</div>
<?php $this->load->view('incs/dt_js.php'); ?>
<script>
$(document).ready(function() {
    var table = $('#dtTable').DataTable( {
        lengthChange: true,
        buttons: ['excel','colvis'],
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
    } );
 
    table.buttons().container()
        .appendTo( '#dtTable_wrapper .col-sm-6:eq(0)' );
} );
        </script>
</body>
</html>
