<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">ODP</h5>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="<?php echo base_url('network/auth/' . encrypt_url('isaddodp')); ?>" class="btn btn-primary btn-icon-text mb-2 mb-md-0 d-none d-md-block text-white">
            <i class="btn-icon-prepend" data-feather="plus"></i>
            Tambah ODP
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h6 class="card-title">Data ODP</h6>
                </div>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Odp Code</th>
                                <th>location</th>
                                <th>wave length</th>
                                <th>power</th>
                                <th>Note</th>
                                <th>status</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $ls) { ?>
                                <tr>
                                    <td><?php echo $ls['odpid']; ?></td>
                                    <td><?php echo $ls['odpcode']; ?></td>
                                    <td>
                                        <?php
                                        echo '<a href="' . $ls['location'] . '">' . $ls['location'] . '</a>';
                                        ?>
                                    </td>
                                    <td><?php echo $ls['wavelength']; ?></td>
                                    <td><?php echo $ls['power']; ?></td>
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
                                                <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('network/odpedit/' . encrypt_url($ls['odpid'])); ?>"><i data-feather="edit" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                                <a class="dropdown-item d-flex align-items-center delete-confirm" data-id="<?= encrypt_url($ls['odpid']); ?>" href="<?= base_url('network/deleteodp'); ?>"><i data-feather="trash-2" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
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
                    url: "<?= base_url('network/deleteodp/'); ?>" + id,
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
                                window.location.href = "<?= base_url('network/auth/' . encrypt_url('isodppage')); ?>";
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