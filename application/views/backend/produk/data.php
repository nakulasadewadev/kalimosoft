<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0"> Data Produk</h5>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="<?php echo base_url('product/auth/' . encrypt_url('isaddproduct')); ?>" class="btn btn-primary btn-icon-text mb-2 mb-md-0 d-none d-md-block text-white">
            <i class="btn-icon-prepend" data-feather="tag"></i>
            Tambah Produk
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h6 class="card-title">Data Produk</h6>
                </div>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Info</th>
                                <th>Harga</th>
                                <th>status</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produk as $p) { ?>
                                <tr>
                                    <td><?php echo $p['noproduct']; ?></td>
                                    <td class="text-uppercase"><?php echo $p['kode']; ?></td>
                                    <td class="text-uppercase"><?php echo $p['nmproduk']; ?></td>
                                    <td class="text-capitalize"><?php echo $p['keterangan']; ?></td>
                                    <td>
                                        <?php echo "Rp " . number_format($p['harga'], 2, ',', '.'); ?>
                                    </td>
                                    <td>
                                        <?php if ($p['status'] == '1') { ?>
                                            <input type="checkbox" class="change" data-id="<?php echo $p['noproduct']; ?>" checked data-toggle="toggle" data-on="Aktif" data-off="Tidak Aktif" data-onstyle="success" data-offstyle="danger" onchange="getChange();">
                                        <?php } else { ?>
                                            <input type="checkbox" class="change" data-id="<?php echo $p['noproduct']; ?>" data-toggle="toggle" data-on="Aktif" data-off="Tidak Aktif" data-onstyle="success" data-offstyle="danger" onchange="getChange();">
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <div class="dropdown mb-2">
                                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <?php $detail = encrypt_url($p['noproduct']); ?>
                                                <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('product/detail/' . $detail); ?>"><i data-feather="edit" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                                <a class="dropdown-item d-flex align-items-center delete-confirm" href="<?= base_url('product/delete'); ?>" data-id="<?= encrypt_url($p['idproduct']); ?>" data-name="<?= $p['nmproduk']; ?>"><i data-feather="trash-2" class="icon-sm mr-2"></i><span class="">Delete</span></a>
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
        const name = $(this).attr('data-name');

        Swal.fire({
            title: 'Apakah Anda Yakin mengahus "' + name + '"?',
            text: "Data yang dihapus akan hilang secara permanen",
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
                    url: "<?= base_url('product/isdeleted/'); ?>" + id,
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
                            icon: data.icon,
                            title: data.title
                        }).then(function() {
                            if (data.status == 200) {
                                window.location.href = "<?= base_url('product/auth/' . encrypt_url('isproduct')); ?>";
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

    $(document).ready(function() {
        ubah();
        getChange();
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
    });

    function getChange(val) {
        $(".change").on('change', function() {
            var id = $(this).attr('data-id');
            console.log(id);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('Product/is_set_aktif'); ?>",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {

                }
            });
        });
    }

    function ubah() {
        $('.js-switch').each(function() {
            var changeCheckbox = document.querySelector('.js-check-change'),
                changeField = document.querySelector('.js-check-change-field');

            changeCheckbox.onchange = function() {
                changeField.innerHTML = changeCheckbox.checked;
            };
        });
    }
</script>