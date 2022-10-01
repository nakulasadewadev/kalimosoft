<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">Maintenance</h5>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h6 class="card-title">Data Maintenance</h6>
                    <hr>
                </div>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>tanggal</th>
                                <th>tiket</th>
                                <th>netid</th>
                                <th>error</th>
                                <th>lokasi</th>
                                <th>status</th>
                                <th>selesai</th>
                                <th>teknisi</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $ls) { ?>
                                <tr>
                                    <td><?= date('d-m-Y H:i:s', strtotime($ls['date'])); ?></td>
                                    <td>#<?= $ls['complainid']; ?></td>
                                    <td><?= $ls['netid']; ?></td>
                                    <td><?= $ls['errorcode']; ?></td>
                                    <td class="text-wrap">
                                        <?= ucwords($ls['address']); ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($ls['status'] == '1') {
                                            echo '<span class="badge badge-pill badge-warning">Baru</span>';
                                        } elseif ($ls['status'] == '2') {
                                            echo '<span class="badge badge-pill badge-info">Proses</span>';
                                        } else {
                                            echo '<span class="badge badge-pill badge-success">Selesai</span>';
                                        }
                                        ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>