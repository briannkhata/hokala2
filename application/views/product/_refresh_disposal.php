<table id="examplee" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width:3%;"><input type="checkbox" class="checkall"></th>
            <th>Barcode</th>
            <th>Category</th>
            <th>Cost</th>
            <th>Accum Dep</th>
            <th>NBV</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($this->M_asset->get_pending_disposal() as $row): ?>
        <tr>
            <td><input type="checkbox" name="asset_id[]" value="<?= $row['asset_id']; ?>"></td>
            <td><?= $row['barcode']; ?> <br> <?= $row['name']; ?></td>
            <td><?= $this->M_category->get_category_name($row['category_id']) ?></td>
            <td><?= number_format($row['cost_price'], 2); ?></td>
            <td><?= $this->M_asset->get_asset_accum_dep($row['asset_id']); ?></td>
            <?php 
               $cost = $row['cost_price'];
               $accum_dep = $this->M_asset->get_asset_accum_dep($row['asset_id']);
               $nbv = $cost - $accum_dep;
               ?>
            <td><?= number_format($nbv, 2); ?></td>
            <td>
               <a href="<?= base_url(); ?>Asset/view/<?= $row['asset_id']; ?>" class="btn btn-primary"> View</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
