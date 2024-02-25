<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('incs/header_dt.php'); ?>
<?php $this->load->view('incs/menu.php'); ?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><?php echo $this->report_model->get_asset_centre_name($cost_centre_id)." ".$quarter_name . " (" . date('Y', strtotime($start_date)) . ")"." Depreciation Expense"; ?></h3>
            </div>
        </div>
        <!-- ... Your content goes here ... -->
        <!-- ... register ... -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Assets depreciation expense
                        <?php 
                       //$cost =  $this->report_model->get_asset_expense_cost(1, '2021-10-01', '2021-12-01'); 
                        //echo $cost;
                        ?>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <?php if ($this->session->flashdata('message')) { ?>
                                <div class="alert alert-success fade in">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                                    <center><?= $this->session->flashdata('Message'); ?> </center>
                                </div>
                            <?php } ?>
                            <table class="table table-striped table-bordered table-hover" id="dtTable" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>Barcode</th>
                                        <th>Description</th>
                                        <th>manufacture</th>
                                        <th>Serial No.</th>
                                        <th>Model No.</th>
                                        <th>Reg No.</th>
                                        <th>Chasis No.</th>
                                        <th>Engine No.</th>
                                        <th>Category</th>
                                        <th>Centre</th>
                                        <th>User/Office</th>
                                        <th>Donor</th>
                                        <th>Acquisition Date</th>
                                        <th>Cost as at <?php echo date('d-M-y', strtotime($start_date)); ?></th>
                                        <th>additions</th>
                                        <th>Valuation</th>
                                        <th>Disposal</th>
                                        <!--cost for disposed asset-->
                                        <th>Value as at <?php echo date('d-M-y', strtotime($end_date)); ?></th>
                                        <th>Dep as <?php echo date('d-M-y', strtotime($start_date)); ?></th>
                                        <th>Charge</th>
                                        <th>Valuation</th>
                                        <th>Disposal</th>
                                        <!--charge for disposed asset-->
                                        <th>Dep as at <?php echo date('d-M-y', strtotime($end_date)); ?></th>
                                        <th>NBV</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="22">Total</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
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
<?php 
//Add those assets disposed after audit start date bcoz they were available by time of audit
$centre_disposed_assets_afta_audit = $this->report_model->count_audit_centre_disposed_assets_afta_audit_start_date($cost_centre_id,$start_date);
$centre_non_disposed_assets = $this->report_model->count_audit_centre_total_assets($cost_centre_id);
//add disposed + non disposed
$centre_total_assets = $centre_disposed_assets_afta_audit + $centre_non_disposed_assets;
///echo $centre_total_assets;
?>
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        var dataTable = $('#dtTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('report/quarter_dep_expense_assets_centre'); ?>",
                type: "POST",
                data:{
                    kota_s_date:<?php echo "'$start_date'"?>,
                    kota_e_date:<?php echo "'$end_date'"?>,
                    cost_centre_id:<?php echo $cost_centre_id?>
                }
            },
            /*drawCallback: function() {
                var sum = $('#dtTable').DataTable().column(4).data().sum();
                $('#total').html(sum);
            },*/
            "columnDefs": [{
                "targets": [0,2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                visible: false, //hide columns  
                "orderable": false,
            }, ],
            lengthChange: true,
            lengthMenu: [ [100,500, <?php echo $centre_total_assets;?>], [100,500, "All"] ],
            "dom": '<"pull-centre"l><"pull-left"B><"pull-right"f>tpir',
            "language": {
            "processing": 'Loading data please wait...'
            //"processing": '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'
                },
            buttons: [{
                    extend: 'excel',
                    text: 'Export to Excel',
                    title: '<?php echo $this->report_model->get_asset_centre_name($cost_centre_id)." ".$quarter_name . " (" . date('Y', strtotime($start_date)) . ")"." Depreciation Expense"; ?>',
                    exportOptions: {
                        //columns: [0,1,2,3,4,6,7,8,9],
                        //columns: ':visible'
                    }
                },
                'colvis',
            ],

        });
        
        table.buttons().container()
            .appendTo('#dtTable_wrapper .col-sm-6:eq(0)');
} );
        
</script>
</body>
</html>