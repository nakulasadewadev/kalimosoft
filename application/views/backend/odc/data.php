<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">ODC</h5>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="<?php echo base_url('network/auth/' . encrypt_url('isaddodc')); ?>" class="btn btn-primary btn-icon-text mb-2 mb-md-0 d-none d-md-block text-white">
            <i class="btn-icon-prepend" data-feather="plus"></i>
            Tambah ODC
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h6 class="card-title">Data ODC</h6>
                </div>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Oltinterface</th>
                                <th>Port</th>
                                <th>Colorcor</th>
                                <th>Location</th>
                                <th>Note</th>
                                <th>status</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $ls) { ?>
                                <tr>
                                    <td><?php echo $ls['odcid']; ?></td>
                                    <td><?php echo $ls['oltinterface']; ?></td>
                                    <td><?php echo $ls['port']; ?></td>
                                    <td>
                                        <?php if ($ls['colorcor'] != '') { ?>
                                            <div class="circle_green" style="background-color:<?php echo $ls['colorcor']; ?>;"></div>
                                        <?php } ?>
                                        <?php if ($ls['color2'] != '') { ?>
                                            <div class="circle_green" style="background-color:<?php echo $ls['color2']; ?>;"></div>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" data-lat="<?php echo $ls['location']; ?>" class="lihat-map"><i data-feather="map-pin" class="icon-lg mr-2 text-primary"></i></a>
                                    </td>
                                    <td><?php echo $ls['note']; ?></td>
                                    <td>
                                        <?php
                                        if ($ls['status'] == 1) {
                                            echo '<span class="bagde badge-pill badge-success">Aktif</span>';
                                        } else {
                                            echo '<span class="bagde badge-pill badge-warning">Tidak Aktif</span>';
                                        }; ?>
                                    </td>
                                    <td>
                                        <div class="dropdown mb-2">
                                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('network/odcedit/' . encrypt_url($ls['Id'])); ?>"><i data-feather="edit" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                                <a class="dropdown-item d-flex align-items-center delete-confirm" data-id="<?= encrypt_url($ls['Id']); ?>" href="<?= base_url('network/deleteodc'); ?>"><i data-feather="trash-2" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
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
        $(".lihat-map").on('click', function() {
            var lat = $(this).attr('data-lat');

            $("#maps").modal('show');
            var html = '<iframe src="http://maps.google.com/maps?q=' + lat + '&z=16&output=embed" height="450" width="100%"></iframe>';
            $(".bodymap").html(html);
        });
    });
</script>

<script type="text/javascript">
    $('.delete-confirm').on('click', function(event) {
        event.preventDefault();
        const url = $(this).attr('href');
        const id = $(this).attr('data-id');

        Swal.fire({
            title: 'Apakah Anda Yakin menghapus data ?',
            text: "Data yang dihapus akan hilang secara permanen dan mempengaruhi data network lainnya",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(function(value) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });

            if (value.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "<?= base_url('network/deleteodc/'); ?>" + id,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    async: false,
                    cache: false,
                    success: function(data) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true,
                        });

                        Toast.fire({
                            icon: data.title,
                            title: data.message
                        }).then(function() {
                            if (data.status == 200) {
                                window.location.href = "<?= base_url('network/auth/' . encrypt_url('isodcpage')); ?>";
                            }
                        });
                    }
                });
            } else if (
                /* Read more about handling dismissals below */
                value.dismiss === Swal.DismissReason.cancel
            ) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                });

                Toast.fire({
                    icon: 'warning',
                    title: 'Batal menghapus data'
                });
            }
        });
    });
</script>