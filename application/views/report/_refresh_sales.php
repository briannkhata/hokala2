<?php $this->load->view('includes/header.php'); ?>
<?php $this->load->view('includes/menu.php'); ?>
<!--start main wrapper-->
<main class="main-wrapper">
   <div class="main-content">
      <h6 class="mb-0 text-uppercase">
         <?= $page_title; ?>
      </h6>
      <hr>
      <div class="col">
         <div class="btn-group">
            <a href="<?= base_url(); ?>Report/sales_report" class="btn btn-secondary">
               Back
            </a>
            <a href="#" class="btn btn-secondary" id="exportBtn">
               EXCELL
            </a>
         </div>
      </div>
      <hr>

      <div class="card-body">
         <table id="examplee" class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th>Barcode</th>
                  <th>Product</th>
                  <th>Description</th>
                  <th>Selling Price</th>
                  <th>Qty</th>
                  <th>Vat</th>
                  <th>Total</th>
                  <th>Sale Date</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $count = 1;
               foreach ($fetch_data as $row): ?>
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
                        <?= number_format($row['price'], 2) ?>
                     </td>
                     <td>
                        <?= number_format($row['qty'], 2) ?>
                     </td>
                     <td>
                        <?= number_format($row['vat'], 2) ?>
                     </td>
                     <td>
                        <?= number_format($row['total'], 2) ?>
                     </td>
                     <td>
                        <?= date("d F d h:m:s", strtotime($row['sale_date'])) ?>
                     </td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
   </div>
</main>
<!--end main wrapper-->
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
      saveAs(new Blob([s2ab(wbout)], { type: "application/octet-stream" }), 'sales_reports.xlsx');
   });

</script>