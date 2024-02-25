<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view('incs/header_dt.php'); ?>
<?php $this->load->view('incs/menu.php'); ?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Approve disposal</h1>
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
                                                    <th>Accum Dep</th>
                                                    <th>NBV</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                    //$count = 1;
                                    foreach($this->asset_model->get_assets_to_be_disposed() as $row){?>
                                    <tr>
                                        <td><?=$row['asset_barcode'];?></td>
                                        <td><?=$row['asset_name'];?></td>
                                        <td><?=$this->asset_model->get_asset_category_name($row['asset_category']);?></td>
                                        <td><?=$this->asset_model->get_asset_centre_name($row['asset_costcentre']);?></td>
                                        <td><?=number_format($row['asset_costprice'],2);?></td>
                                        <td><?=$this->asset_model->get_asset_accum_dep($row['assetID']);?></td>
                                        <?php 
                                        //calc NBV
                                        $cost = $row['asset_costprice'];
                                        $accum_dep = $this->asset_model->get_asset_accum_dep($row['assetID']);
                                        $nbv = $cost - $accum_dep;
                                        ?>
                                        <td><?=number_format($nbv,2);?></td>
                                       
                                        <td>
                                        <div class="btn-group">
											  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Action <span class="caret"></span></button>
											  <ul class="dropdown-menu">
												<li><a  href="<?=base_url('asset/view/');?><?=$row['assetID'];?>"><i class="fa fa-info-circle"></i> View</a></li>
                                                <li><a  onclick="return confirm('Are you sure you want to reject disposal this asset?');" href="<?=base_url('asset/dispose_reject/');?><?=$row['assetID'];?>"><i class="fa fa-times-circle"></i> Reject</a></li>
                                                <li><a  onclick="return confirm('Are you sure you want to approve disposal?');" href="<?=base_url('asset/dispose_approve/');?><?=$row['assetID'];?>"><i class="fa fa-check"></i> Approve</a></li>
											  </ul>
											</div>
                                        </td>
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
        buttons: [ 'excel','colvis'],
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        //buttons: [ 'copy', 'excel', 'pdf', 'colvis']
    } );
    table.buttons().container()
        .appendTo( '#dtTable_wrapper .col-sm-6:eq(0)' );
} );
        </script>
</body>
</html>
