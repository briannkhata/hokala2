<table id="examplee" class="table table-striped table-bordered">
   <thead>
      <tr>
         <th style="width:4px">
            <input type="checkbox" class="audit-checkbox">
         </th>
         <th>Barcode</th>
         <th>Description</th>
         <th>Category</th>
         <th>Centre</th>
         <th>Acquisition Date</th>
         <th>Acquisition Cost</th>
      </tr>
   </thead>
   <tbody>
      <?php 
         $count = 1;
         foreach ($thi->M_asset->get_finished_audited_assets() as  $row): ?>
      <tr>
         <td><input type="checkbox" class="audit-checkbox" value="<?= $row['asset_id'] ?>"></td>
         <td><?= $row['barcode'] ?></td>
         <td><?= $row['name'] ?></td>
         <td><?= $this->M_category->get_category_name($row['category_id']) ?></td>
         <td><?= $this->M_centre->get_centre($row['centre_id']) ?></td>
         <td><?= date("d-M-Y", strtotime($row['purchase_date'])) ?></td>
         <td><?= number_format($row['cost_price'], 2) ?></td>
      </tr>
      <?php endforeach; ?>
   </tbody>
</table>