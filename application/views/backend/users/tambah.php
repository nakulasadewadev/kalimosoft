<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">Data User</h5>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('users/auth/' . encrypt_url('isusers')); ?>">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h6 class="card-title">form tambah users</h6>
                    <hr>
                </div>
                <div class="card-body">
                    <form id="send_data" class="forms-sample myForm">
                        <div class="form-group form-row">
                            <label class="col-md-2 col-sm-3 col-form-label text-sm-right">
                                ID Users
                            </label>
                            <div class="col-md-7 col-sm-9">
                                <input type="text" class="form-control" value="<?php echo $id_user; ?>" name="idusers" id="idusers" readonly />
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label class="col-md-2 col-sm-3 col-form-label text-sm-right">
                                Nama Lengkap
                            </label>
                            <div class="col-md-7 col-sm-9">
                                <input type="text" class="form-control" required name="nama" id="nama" />
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label class="col-md-2 col-sm-3 col-form-label text-sm-right">
                                Email
                            </label>
                            <div class="col-md-7 col-sm-9">
                                <input type="email" class="form-control" required name="email" id="email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" />
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label class="col-md-2 col-sm-3 col-form-label text-sm-right">
                                Groups
                            </label>
                            <div class="col-md-7 col-sm-9">
                                <select name="groups" id="groups" class="form-control groups">
                                    <option value="">-select-</option>
                                    <?php foreach ($groups as $g) { ?>
                                        <option value="<?= $g['idgroups']; ?>">
                                            <?= $g['groups']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-row">
                            <label class="col-md-2 col-sm-3 col-form-label text-sm-right">
                                Password
                            </label>
                            <div class="col-md-7 col-sm-9">
                                <input type="password" class="form-control" minlength="8" required name="password" id="password" />
                            </div>
                        </div>
                        <hr>
                        <div class="form-group form-row">
                            <div class="col-xl-9 offset-xl-2">
                                <button class="btn btn-success" id="btn_upload" type="submit">
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

<script type="text/javascript">
    $(document).ready(function() {
        $("#send_data").submit(function(ev) {
            ev.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?= base_url('users/auth/' . encrypt_url('isprosesadd')); ?>",
                data: new FormData(this),
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
                        $(".myForm")[0].reset();
                        window.location.href = "<?= base_url('users/auth/' . encrypt_url('isusers')); ?>";
                    });
                }
            });
        })
    });
</script>