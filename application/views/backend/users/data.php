<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">Data User</h5>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="<?php echo base_url('users/auth/' . encrypt_url('isaddusers')); ?>" class="btn btn-primary btn-icon-text mb-2 mb-md-0 d-none d-md-block text-white">
            <i class="btn-icon-prepend" data-feather="user-plus"></i>
            Tambah Users
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs mt-6" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?= $tab == null ? 'active' : ''; ?>" id="chats-tab" data-toggle="tab" href="#chats" role="tab" aria-controls="chats" aria-selected="true">
                            <div class="d-flex flex-row flex-lg-column flex-xl-row align-items-center">
                                <i data-feather="user" class="icon-sm mr-sm-2 mr-lg-0 mr-xl-2 mb-md-1 mb-xl-0"></i>
                                <p class="d-none d-sm-block">Users</p>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $tab == 'group' ? 'active' : ''; ?>" id="calls-tab" data-toggle="tab" href="#calls" role="tab" aria-controls="calls" aria-selected="false">
                            <div class="d-flex flex-row flex-lg-column flex-xl-row align-items-center">
                                <i data-feather="users" class="icon-sm mr-sm-2 mr-lg-0 mr-xl-2 mb-md-1 mb-xl-0"></i>
                                <p class="d-none d-sm-block">Groups</p>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="depart-tab" data-toggle="tab" href="#depart" role="tab" aria-controls="depart" aria-selected="false">
                            <div class="d-flex flex-row flex-lg-column flex-xl-row align-items-center">
                                <i data-feather="user-plus" class="icon-sm mr-sm-2 mr-lg-0 mr-xl-2 mb-md-1 mb-xl-0"></i>
                                <p class="d-none d-sm-block">Tambah Group</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content mt-3">
                    <div class="tab-pane fade <?= $tab == null ? 'show active' : ''; ?>" id="chats" role="tabpanel" aria-labelledby="chats-tab">
                        <div class="card-title">
                            <h6 class="card-title">data user</h6>
                            <hr>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>ID.Users</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Groups</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($user as $us) { ?>
                                        <tr>
                                            <td><?php echo $us['nik']; ?></td>
                                            <td class="text-capitalize">
                                                <?php echo $us['nama']; ?>
                                            </td>
                                            <td>
                                                <?php echo $us['email']; ?>
                                            </td>
                                            <td class="text-uppercase">
                                                <?php
                                                $group = $this->db->get_where('groups_menu', array('idgroups' => $us['groups']))->row()->groups;
                                                echo $group;
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($us['status'] == '1') { ?>
                                                    <input type="checkbox" class="change" data-id="<?php echo $us['idadminuser']; ?>" checked data-toggle="toggle" data-on="Aktif" data-off="Tidak Aktif" data-onstyle="success" data-offstyle="danger" onchange="getChange();">
                                                <?php } else { ?>
                                                    <input type="checkbox" class="change" data-id="<?php echo $us['idadminuser']; ?>" data-toggle="toggle" data-on="Aktif" data-off="Tidak Aktif" data-onstyle="success" data-offstyle="danger" onchange="getChange();">
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <div class="dropdown mb-2">
                                                    <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item d-flex align-items-center" href="<?= base_url('users/auth/' . encrypt_url('isdetail/' . $us['idadminuser'])) ?>"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                                                        <a class="dropdown-item d-flex align-items-center delete-confirm" data-id="<?= encrypt_url($us['idadminuser']); ?>" data-name="<?= $us['nama']; ?>" href="<?= base_url('users/delete'); ?>"><i data-feather="trash-2" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade <?= $tab == 'group' ? 'show active' : ''; ?>" id="calls" role="tabpanel" aria-labelledby="calls-tab">
                        <div class="card-title">
                            <h6 class="card-title">data groups</h6>
                            <hr>
                        </div>
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="keluhan" class="table">
                                    <thead>
                                        <tr>
                                            <th>ID.Groups</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($groups as $g) { ?>
                                            <tr>
                                                <td><?php echo $g['idgroups']; ?></td>
                                                <td class="text-uppercase">
                                                    <?php echo $g['groups']; ?>
                                                </td>
                                                <td>
                                                    <?php if ($g['status'] == '1') {
                                                        echo '<span class="badge badge-pill badge-success">Aktif</span>';
                                                    } else {
                                                        echo '<span class="badge badge-pill badge-warning">Tidak Aktif</span>';
                                                    } ?>
                                                </td>
                                                <td>
                                                    <div class="dropdown mb-2">
                                                        <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('users/editgroups/' . encrypt_url($g['idgroups'])); ?>"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
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
                    <div class="tab-pane fade" id="depart" role="tabpanel" aria-labelledby="depart-tab">
                        <div class="card-title">
                            <h6 class="card-title">tambah groups</h6>
                            <hr>
                        </div>
                        <form id="addgroup">
                            <div class="form-group form-row">
                                <label class="col-md-2 col-sm-3 col-form-label text-sm-left">
                                    Groups
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="group" id="group" class="form-control text-uppercase" required>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group form-row">
                                <div class="col-xl-9 offset-xl-2">
                                    <button class="btn btn-success" id="btn_proses" type="submit">
                                        <i class="icon icon-check icon-fw icon-lg"></i>
                                        Proses
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
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
                    url: "<?= base_url('users/isdeleted/'); ?>" + id,
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
                                window.location.href = "<?= base_url('users/auth/' . encrypt_url('isusers')); ?>";
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
                url: "<?php echo base_url('users/is_set_aktif'); ?>",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {}
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

    $(document).ready(function() {
        $("#btn_proses").on('click', function(ev) {
            ev.preventDefault();
            var nama = $('#group').val();
            console.log(nama);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('users/auth/' . encrypt_url('istambahgroup')); ?>",
                data: {
                    group: nama
                },
                dataType: "JSON",
                async: false,
                cache: false,
                success: function(data) {
                    console.log(data);
                    if (data.status == '200') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Groups Berhasil Di Tambah'
                        });
                    }
                    if (data.status == '201') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: 'Group Tidak Bisa Di Tambah, Nama Group Sudah Ada'
                        });
                    }
                    if (data.status == '202') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'error',
                            title: 'Group Tidak Bisa Di Tambah, Silakan Coba Lagi'
                        });
                    }
                }
            });
        });
    });
</script>