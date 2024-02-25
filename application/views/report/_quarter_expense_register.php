<?php $this->load->view("includes/header.php"); ?>
<?php $this->load->view("includes/menu.php"); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
      <h6 class="mb-0 text-uppercase"><?= $page_title ?></h6>
      <hr>
   </div>
   <div class="card">
   <div class="card-body">
      <div class="table-responsive">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                Asset Register
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="table-responsive">
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
                                        </table>
                                        </div>
   </div>
</main>
<!--end main wrapper-->
<?php $this->load->view("includes/footer.php"); ?>
<?php 
//Add those assets disposed after audit start date bcoz they were available by time of audit
$disposed_assets_afta_audit = $this->M_report->count_audit_disposed_assets_afta_audit_start_date($start_date);
$non_disposed_assets = $this->M_report->count_audit_total_assets();
//add disposed + non disposed
$total_assets = $disposed_assets_afta_audit + $non_disposed_assets;
///echo $centre_total_assets;
?>
<script type="text/javascript" language="javascript" >  
 $(document).ready(function(){  
        var dataTable = $('#dtTable').DataTable({  
           "processing":true,  
           "serverSide":true,
           "bProcessing": true,  
           "ajax":{  
                url:"<?php echo base_url('report/quarter_dep_expense_assets'); ?>",  
                type: "POST",
                data:{
                    kota_s_date:<?php echo "'$start_date'";?>,
                    kota_e_date:<?php echo "'$end_date'";?>
                },
                //bDeferRender: true,
                //scrollY: 50,
                //deferRender: true,
                //scroller: true
           },  
           "order":[],  
           "bSortClasses": false,
           "dom": '<"pull-centre"l><"pull-left"B><"pull-right"f>tpir',
           "language": {
            "processing": 'Loading data please wait...'
                },
           "columnDefs":[{  
                    //"targets"  : 'no-sort',
                     "targets":[0,2,3,4,5,6,7,8,9,10,11,12], 
                     visible: false, //hide columns
                     //"targets": '_all', visible: false,
                     "orderable":false,  
                },  
           ], 
           //lengthChange: true,
           lengthMenu: [ [50,100,500, <?php echo $total_assets;?>], [50,100,500, "All"] ],
           buttons: [
               {
                extend: 'excel',
                text: 'Export to Excel',
                title: 'All Cost Centres <?php echo $quarter_name . " (" . date('Y', strtotime($start_date)) . ")"." Depreciation Expense"; ?>',
                exportOptions: {
                    //columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13],
                    //columns: ':visible'
                }
            },
            'colvis',
        ],
         
      });  
      table.buttons().container()
        .appendTo('#dtTable_wrapper .col-sm-6:eq(0)');
   

 }); //end doc
 
 </script>


