<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<main class="main-wrapper">
   <div class="main-content">
      <div class="card">
         <div class="card-body">
            <h5 class="card-title">
               <?= $page_title; ?>
            </h5>
            <hr>

            <div class="col">
               <div class="btn-group">
                  <a href="#" class="btn btn-secondary" id="exportBtn">
                     EXCELL
                  </a>
               </div>
            </div>

         </div>

         <div class="card-body">
            <table id="examplee" class="table table-striped table-bordered" style="width:100%">
               <thead>
                  <tr>
                     <th>Barcode</th>
                     <th>Product</th>
                     <th>Description</th>
                     <th>Category</th>
                     <th>Selling Price</th>
                     <th>Reorder Level</th>
                     <th>Quantity</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  foreach ($this->M_product->get_expired_products() as $row): ?>
                     <tr>

                        <td>
                           <?= $row['barcode'] ?>
                        </td>
                        <td>
                           <?= $row['name'] ?>
                        </td>
                        <td>
                           <?= $row['desc'] ?>
                        </td>
                        <td>
                           <?= $this->M_category->get_category_name($row['category_id']) ?>
                        </td>

                        <td>
                           <?= number_format($row['selling_price'], 2) ?>
                        </td>
                        <td>
                           <?= $row['reorder_level']; ?>
                        </td>
                        <td>
                           <?= $row['qty']; ?>
                        </td>

                     </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>

         </div>
      </div>

   </div>


</main>

<?php $this->load->view('includes/footer.php'); ?>
<script>
   $('#exportBtn').click(function () {
      var table = document.getElementById('examplee');
      $(table).find('thead th').css('font-weight', 'bold');
      $(table).find('tbody td').css('text-align', 'center');
      var wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
      var wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });
      function s2ab(s) {
         var buf = new ArrayBuffer(s.length);
         var view = new Uint8Array(buf);
         for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
         return buf;
      }
      saveAs(new Blob([s2ab(wbout)], { type: "application/octet-stream" }), 'inventory_reports.xlsx');
   });

</script>