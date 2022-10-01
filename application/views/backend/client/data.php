<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0"> Data Client</h5>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>NoID</th>
                                <th>tanggal daftar</th>
                                <th>KTP</th>
                                <th>customer</th>
                                <th>alamat</th>
                                <th>kota</th>
                                <th>no. telepon</th>
                                <th>id telegram</th>
                                <th>email</th>
                                <th>profesi</th>
                                <th>status</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $ls) { ?>
                                <tr>
                                    <td><?= $ls['cid']; ?></td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($ls['create_at'])); ?></td>
                                    <td class="text-capitalize">
                                        <?php
                                        if (!empty($ls['ktp'])) {
                                            echo '<a href="#" data-path="' . $ls['ktp'] . '" data-cid="' . $ls['cid'] . '" class="lihat-ktp"><i data-feather="credit-card" class="icon-sm mr-2 text-primary"></i></a>';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-capitalize"><?= $ls['name']; ?></td>
                                    <td class="text-capitalize"><?= $ls['address']; ?></td>
                                    <td>
                                        <?= ucwords($ls['nama_kota']); ?>
                                    </td>
                                    <td><?= $ls['handphone']; ?></td>
                                    <td><?= $ls['telegram']; ?></td>
                                    <td><?= $ls['email']; ?></td>
                                    <td class="text-uppercase"><?= $ls['profession']; ?></td>
                                    <td>
                                        <?php if ($ls['status'] == '1') { ?>
                                            <input type="checkbox" class="change" data-id="<?= $ls['cid']; ?>" checked data-toggle="toggle" data-on="Member" data-off="Prospective" data-onstyle="success" data-offstyle="danger" onchange="getChange();">
                                        <?php } else { ?>
                                            <input type="checkbox" class="change" data-id="<?= $ls['cid']; ?>" data-toggle="toggle" data-on="Member" data-off="Prospective" data-onstyle="success" data-offstyle="danger" onchange="getChange();">
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <div class="dropdown mb-2">
                                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <?php
                                                $id = $ls['cid'];
                                                ?>
                                                <a class="dropdown-item d-flex align-items-center" href="<?= base_url(); ?>client/edit/<?= encrypt_url($id); ?>"><i data-feather="edit" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                                <a class="dropdown-item d-flex align-items-center delete-confirm" data-id="<?= encrypt_url($id); ?>" data-name="<?= $ls['name']; ?>" href="<?= base_url('client/isdeleted'); ?>"><i data-feather="trash-2" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
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

<div id="ktp" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-capitalize">KTP</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="bodymap"></div>
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
            title: 'Apakah Anda Yakin menghapus "' + name + '"?',
            text: "Menghapus Data Client akan mempengaruhi data Network, Transaksi, Billing, Invioce & Payment",
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
                    url: "<?= base_url('client/isdeleted/'); ?>" + id,
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
                                window.location.href = "<?= base_url('client/auth/' . encrypt_url('isclient')); ?>";
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
        $.ajax({
            type: "POST",
            url: "<?= base_url('client/auth/' . encrypt_url('is_send_ajax')); ?>",
            dataType: "JSON",
            async: false,
            success: function(data) {
                console.log(data);
            }
        });

        ubah();
        getChange();
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });

        $(".lihat-ktp").on('click', function() {
            var path = $(this).attr('data-path');
            var cid = $(this).attr('data-cid');

            //var long= $(this).attr('data-long');
            $("#ktp").modal('show');
            var html = '<img src="<?= base_url('uploads/ktp/') ?>' + cid + '/' + path + '" alt="KTP" class="img-fluid">';
            $(".bodymap").html(html);
        });
    });

    function getChange(val) {
        $(".change").on('change', function() {
            var id = $(this).attr('data-id');
            console.log(id);
            $.ajax({
                type: "POST",
                url: "<?= base_url('client/is_set_aktif'); ?>",
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