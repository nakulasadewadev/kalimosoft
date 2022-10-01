<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h6 class="card-title">Data Tagihan Bulan Ini</h6>
                </div>
                <div class="table-responsive">
                    <table id="tagihan" class="table">
                        <thead>
                            <tr>
                                <th>tanggal</th>
                                <th>netid</th>
                                <th>member</th>
                                <th>lokasi</th>
                                <th>produk</th>
                                <th>tagihan</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($billing as $ls) { ?>
                                <tr>
                                    <td><?= date('d-m-Y H:i:s', strtotime($ls['end_at'])); ?></td>
                                    <td><?= $ls['netid']; ?></td>
                                    <td>
                                        <?= ucwords($ls['name']) ?>
                                    </td>
                                    <td class="text-capitalize">
                                        <?= ucwords($ls['address']); ?>
                                    </td>
                                    <td>
                                        <?= strtoupper($ls['kode']); ?>
                                    </td>
                                    <td>
                                        <?= "Rp " . number_format($ls['bill'], 2, ',', '.'); ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($ls['statbilling'] == 1) {
                                            echo '<span class="badge badge-pill badge-success">ONLINE</span>';
                                        } else {
                                            echo '<span class="badge badge-pill badge-warning">OVER DUE</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>