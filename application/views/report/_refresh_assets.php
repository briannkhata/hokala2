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

                        <a href="<?= base_url(); ?>Report/asset" class="btn btn-secondary">
                            BACK
                        </a>
                        <a href="#" class="btn btn-primary" id="exportBtn">
                            EXCELL
                        </a>


                    </div>


                </div>
                <br>

                <?php
                if (isset($fetch_data) || count($fetch_data) > 0) { ?>
                    <table id="examplee" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width:4px">#</th>
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
                            foreach ($fetch_data as $row): ?>
                                <tr>
                                    <td>
                                        <?= $count++; ?>
                                    </td>
                                    <td>
                                        <?= $row['barcode'] ?>
                                    </td>
                                    <td>
                                        <?= $row['name'] ?>
                                    </td>
                                    <td>
                                        <?= $this->M_category->get_category_name($row['category_id']) ?>
                                    </td>
                                    <td>
                                        <?= $this->M_centre->get_centre($row['centre_id']) ?>
                                    </td>
                                    <td>
                                        <?= date("d-M-Y", strtotime($row['purchase_date'])) ?>
                                    </td>
                                    <td>
                                        <?= number_format($row['cost_price'], 2) ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php } ?>

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
        saveAs(new Blob([s2ab(wbout)], { type: "application/octet-stream" }), 'AssetRegister.xlsx');
    });

</script>