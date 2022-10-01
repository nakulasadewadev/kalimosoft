<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h6 class="card-title">Data Keluhan Terbaru</h6>
                </div>
                <div class="table-responsive">
                    <table id="keluhan" class="table">
                        <thead>
                            <tr>
                                <th>tanggal</th>
                                <th>tiket</th>
                                <th>netid</th>
                                <th>lokasi</th>
                                <th>map</th>
                                <th>keluhan</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($error as $e) { ?>
                                <tr>
                                    <td><?php echo date('d-m-Y H:i:s', strtotime($e['date'])); ?></td>
                                    <td class="text-danger">#<?php echo $e['complainid']; ?></td>
                                    <td><?php echo $e['netid']; ?></td>
                                    <td class="text-wrap">
                                        <?= ucwords($e['address']); ?>
                                    </td>
                                    <td>
                                        <a href="#" data-lat="<?= $e['location']; ?>" class="lihat-map"><i data-feather="map-pin" class="icon-sm mr-2 text-primary"></i></a>
                                    </td>
                                    <td class="text-white">
                                        <a class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="top" data-content="<?= ucwords($e['description']); ?>">
                                            <?= $e['errorcode']; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                        if ($e['status'] == '1') {
                                            echo '<span class="badge badge-pill badge-warning">Baru</span>';
                                        } elseif ($e['status'] == '2') {
                                            echo '<span class="badge badge-pill badge-info">Proses</span>';
                                        } else {
                                            echo '<span class="badge badge-pill badge-success">Selesai</span>';
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

<div id="maps" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-capitalize">lokasi pemasangan</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="bodymap"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(function() {
            $('[data-toggle="popover"]').popover()
        });
        $(".lihat-map").on('click', function() {
            var lat = $(this).attr('data-lat');
            //var long= $(this).attr('data-long');
            $("#maps").modal('show');
            var html = '<iframe src="http://maps.google.com/maps?q=' + lat + '&z=16&output=embed" height="450" width="100%"></iframe>';
            $(".bodymap").html(html);
        });
    });
</script>