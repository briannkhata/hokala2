<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $this->load->view('incs/header_dt.php'); ?>
<?php $this->load->view('incs/menu.php'); ?>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header"><?php echo $this->asset_model->get_asset_category_name($this->uri->segment(3)); ?> Assets</h1>
                </div>
            </div>
            <!-- ... Your content goes here ... -->
                  <!-- ... register ... -->
                  <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                <?php echo $this->asset_model->get_asset_category_name($this->uri->segment(3)); ?> Assets
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
                                                    <th>Acquisition Cost</th>
                                                    <th></th>
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
     //onchange event
 $(document).on('change', '#centre', function(){
        var centre = $(this).val();
       $('#dtTable').DataTable().destroy();
        if(centre != ''){
        load_data(centre);
        }else{
        load_data();
       }
 });
    load_data();
    function load_data(is_costcentre){
        var dataTable = $('#dtTable').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url('asset/fetch_assets_by_category/'.$this->uri->segment(3)); ?>",  
                type:"POST",
                //data:{is_costcentre:is_costcentre}
           },  
           "columnDefs":[{  
                    //"targets"  : 'no-sort',
                     "targets":[2,3,4,5,6,7,10,11], visible: false, //hide columns
                     //"targets": '_all', visible: false,
                     "orderable":false,  
                },  
           ], 
           //lengthChange: true,
           lengthMenu: [ [25, 50,100,500,1000, -1], [25, 50,100,500,1000, "All"] ],
           "dom": '<"pull-centre"l><"pull-left"B><"pull-right"f>tpi',
           buttons: [{
                text: 'New asset',
                action: function ( e, dt, node, config ){
                location.href = 'crud';
                    }
               },
               {
                extend: 'excel',
                text: 'Export to Excel',
                title: '<?php echo $this->asset_model->get_asset_category_name($this->uri->segment(3)); ?> Assets',
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13],
                    //columns: ':visible'
                }
            },
            'colvis',
        ],
         
      });  
      table.buttons().container()
        .appendTo('#dtTable_wrapper .col-sm-6:eq(0)');

    } //end load data function
   

 }); //end doc
 
 </script>
</body>
</html>

