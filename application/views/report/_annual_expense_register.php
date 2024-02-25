<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view('incs/header_dt.php'); ?>
<?php $this->load->view('incs/menu.php'); ?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">All Cost Centres Annual Depreciation Expense<?php echo " (" . date('Y', strtotime($start_date)) . ")"; ?></h3>
                </div>
            </div>
            <!-- ... Your content goes here ... -->
                  <!-- ... register ... -->
                  <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                Depreciation expense report
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
<script type="text/javascript" language="javascript" >  
 $(document).ready(function(){  
        var dataTable = $('#dtTable').DataTable({  
           "processing":true,  
           "serverSide":true,
           "bProcessing": true,  
           "ajax":{  
                url:"<?php echo base_url('report/annual_dep_expense_assets'); ?>",  
                type: "POST",
                data:{kota_s_date:<?php echo "'$start_date'";?>,kota_e_date:<?php echo "'$end_date'";?>},
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
           lengthMenu: [ [50,100,500, -1], [50,100,500, "All"] ],
           buttons: [
               {
                extend: 'excel',
                text: 'Export to Excel',
                title: 'All Cost Centres Depreciation Expense <?php echo "(" . date('Y', strtotime($start_date)) . ")"; ?>',
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
</body>
</html>

