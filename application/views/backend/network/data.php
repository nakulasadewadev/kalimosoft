<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">NETWORK</h5>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h6 class="card-title">Data NETWORK</h6>
                </div>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Net.ID</th>
                                <th>Client</th>
                                <th>Olt</th>
                                <th>Odp</th>
                                <th>Odc</th>
                                <th>Ontid</th>
                                <th>Produk</th>
                                <th>NetStatus</th>
                                <th>Map</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $ls) { ?>
                                <tr>
                                    <td><?= date('d-m-Y H:i:s', strtotime($ls['create_at'])); ?></td>
                                    <td><?= $ls['netid']; ?></td>
                                    <td class="text-capitalize">
                                        <?= ucwords($ls['name']); ?>
                                    </td>
                                    <td><?= $ls['oltid']; ?></td>
                                    <td>
                                        <?= $ls['odpcode']; ?>
                                    </td>
                                    <td><?= $ls['odcport']; ?></td>
                                    <td><?= $ls['ontid']; ?></td>
                                    <td>
                                        <?= strtoupper($ls['kode']); ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($ls['netstatus'] == 1) {
                                            echo '<span class="badge badge-pill badge-success text-uppercase">online</span>';
                                        } else {
                                            echo '<span class="badge badge-pill badge-danger text-uppercase">offline</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="#" data-lat="<?= $ls['location']; ?>" class="lihat-map"><i data-feather="map-pin" class="icon-sm mr-2 text-primary"></i></a>
                                    </td>
                                    <td>
                                        <div class="dropdown mb-2">
                                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <?php
                                                $detail = encrypt_url($ls['netid']);
                                                ?>
                                                <a class="dropdown-item d-flex align-items-center" href="<?= base_url('network/detail/' . $detail); ?>"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                                                <a class="dropdown-item d-flex align-items-center" href="<?= base_url('network/edit/' . $detail); ?>"><i data-feather="edit" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                                <a class="dropdown-item d-flex align-items-center hapus" data-id="<?= $ls['netid']; ?>" href="#"><i data-feather="trash" class="icon-sm mr-2 text-danger"></i> <span class="">Hapus</span></a>
                                                <?php if ($ls['netstatus'] == 1) { ?>
                                                    <a class="dropdown-item d-flex align-items-center set-offline" data-id="<?= $ls['netid']; ?>" href="#"><i data-feather="cloud-off" class="icon-sm mr-2 text-danger"></i> <span class="">Set OffLine</span></a>
                                                <?php } else { ?>
                                                    <a class="dropdown-item d-flex align-items-center set-online" data-id="<?= $ls['netid']; ?>" href="#"><i data-feather="cloud" class="icon-sm mr-2 text-success"></i> <span class="">Set OnLine</span></a>
                                                <?php } ?>
                                            </div>
                                        </div>
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
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });

        $(".hapus").on('click', function() {
            var netid = $(this).attr('data-id');
            Swal.fire({
                title: 'Yakin Menghapus Data Net.ID : ' + netid + ' ?',
                text: "Menghapus Data Network akan mempengaruhi data Transaksi, Billing, Invioce & Payment",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'mr-2',
                confirmButtonText: 'YA',
                cancelButtonText: 'TIDAK',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('network/ishapus'); ?>",
                        data: {
                            netid: netid
                        },
                        dataType: "JSON",
                        async: false,
                        cache: false,
                        success: function(data) {
                            if (data == 200) {
                                Swal.fire(
                                    'Berhasil',
                                    'NET.ID : ' + netid + ' Berhasil Di Hapus',
                                    'success'
                                ).then(function() {
                                    window.location.reload();
                                });
                            }
                        }
                    });

                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    // Swal.fire(
                    //     'Cancelled',
                    //     'Your imaginary file is safe :)',
                    //     'error'
                    // )
                    window.location.reload();
                }
            })
        });

        $(".set-offline").on('click', function() {
            var netid = $(this).attr('data-id');
            Swal.fire({
                title: 'Set Offline ?',
                text: "Apakah Anda Yakin Mau Set Offline Net.ID : " + netid,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'mr-2',
                confirmButtonText: 'YA',
                cancelButtonText: 'TIDAK',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('network/setoffline'); ?>",
                        data: {
                            netid: netid
                        },
                        dataType: "JSON",
                        async: false,
                        cache: false,
                        success: function(data) {
                            if (data == 200) {
                                Swal.fire(
                                    'Berhasil',
                                    'NET.ID : ' + netid + ' Berhasil Di Set Offline',
                                    'success'
                                ).then(function() {
                                    window.location.reload();
                                });
                            }
                        }
                    });

                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    // Swal.fire(
                    //     'Cancelled',
                    //     'Your imaginary file is safe :)',
                    //     'error'
                    // )
                    window.location.reload();
                }
            })
        });

        $(".set-online").on('click', function() {
            var netid = $(this).attr('data-id');
            Swal.fire({
                title: 'Set Online ?',
                text: "Apakah Anda Yakin Mau Set Online Net.ID : " + netid,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'mr-2',
                confirmButtonText: 'YA',
                cancelButtonText: 'TIDAK',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('network/setonline'); ?>",
                        data: {
                            netid: netid
                        },
                        dataType: "JSON",
                        async: false,
                        cache: false,
                        success: function(data) {
                            if (data == 200) {
                                Swal.fire(
                                    'Berhasil',
                                    'NET.ID : ' + netid + ' Berhasil Di Set Online',
                                    'success'
                                ).then(function() {
                                    window.location.reload();
                                });
                            } else if (data == 201) {
                                Swal.fire(
                                    'GAGAL',
                                    'NET.ID : ' + netid + ' Masih Belum Lengkap : ODC , ODP , dan OLT. Silakan Di Lengkapi Dahulu',
                                    'error'
                                ).then(function() {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'GAGAL',
                                    'NET.ID : ' + netid + ' Gagal Di Update, Silakan Coba Lagi',
                                    'error'
                                ).then(function() {
                                    window.location.reload();
                                });
                            }
                        }
                    });

                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    // Swal.fire(
                    //     'Cancelled',
                    //     'Your imaginary file is safe :)',
                    //     'error'
                    // )
                    window.location.reload();
                }
            })
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