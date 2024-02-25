<table id="examplee" class="table table-striped table-bordered">
   <thead>
      <tr>
         <th>#</th>
         <th>User</th>
         <th>Action</th>
      </tr>
   </thead>
   <tbody>
      <?php 
         $count = 1;
         foreach ($this->M_asset->get_paused_audited_assets() as  $row): ?>
      <tr>
         <td><?= $row['transaction_id'] ?></td>
         <td><?= $this->M_user->get_name($row['user_id']) ?></td>
         <td></td>
      </tr>
      <?php endforeach; ?>
   </tbody>
</table>
