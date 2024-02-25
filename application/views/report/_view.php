<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view('incs/header.php'); ?>
<?php $this->load->view('incs/menu.php'); ?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Asset information</h1>
                </div>
            </div>
            <!-- ... Your content goes here ... -->
                  <!-- ... register ... -->
                  <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                Asset information
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                <table class="table" style="width:50%; border:none;">
                                <?php foreach($details as $row){?>
                                <tr>
                                <th style="border:none">Barcode</th>
                                <td style="border:none"><?=$row['asset_barcode'];?></td>
                                </tr>
                                <tr>
                                <th style="border:none">Description</th>
                                <td style="border:none"><?=$row['asset_name'];?></td>
                                </tr>
                                <tr>
                                <th style="border:none">Category</th>
                                <td style="border:none"><?=$this->asset_model->get_asset_category_name($row['asset_category']);?></td>
                                </tr>
                                <tr>
                                <th style="border:none">Cost Centre</th>
                                <td style="border:none"><?=$this->asset_model->get_asset_centre_name($row['asset_costcentre']);?></td>
                                </tr>
                                <tr>
                                <th style="border:none">User</th>
                                <td style="border:none"><?=$this->asset_model->get_asset_user_name($row['asset_user']);?></td>
                                </tr>
                                <tr>
                                <th style="border:none">Acquisition Date</th>
                                <td style="border:none"><?=date('d F Y',strtotime($row['asset_purchasedDate']));?></td>
                                </tr>
                                <tr>
                                <th style="border:none">Acquisition cost</th>
                                <td style="border:none"><?=$row['asset_costprice'];?></td>
                                </tr>
                                <tr>
                                <th style="border:none">Manufacture</th>
                                <td style="border:none"><?=$row['asset_manufacture'];?></td>
                                </tr>
                                <tr>
                                <th style="border:none">Model Number</th>
                                <td style="border:none"><?=$row['asset_model'];?></td>
                                </tr>
                                <tr>
                                <th style="border:none">Serial Number</th>
                                <td style="border:none"><?=$row['asset_serialNo'];?></td>
                                </tr>
                                <tr>
                                <th style="border:none">Registration Number</th>
                                <td style="border:none"><?=$row['asset_regNo'];?></td>
                                </tr>
                                <tr>
                                <th style="border:none">Chasis Number</th>
                                <td style="border:none"><?=$row['chasis_no'];?></td>
                                </tr>
                                <tr>
                                <th style="border:none">Engine Number</th>
                                <td style="border:none"><?=$row['asset_engineNo'];?></td>
                                </tr>
                                <tr>
                                <th style="border:none">Useful Years</th>
                                <td style="border:none"><?=$row['life_span'];?></td>
                                </tr>
                                <tr>
                                <th style="border:none">Used Years</th>
                                <td style="border:none"><?=$row['no_years_elapsed'];?></td>
                                </tr>
                                <tr>
                                <th style="border:none">Remaining Years</th>
                                <td style="border:none"><?=$row['no_years_remaining'];?></td>
                                </tr>
                                <?php }?>
                                </table>
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
<?php $this->load->view('incs/footer.php'); ?>
