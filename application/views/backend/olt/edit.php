<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0 text-uppercase">OLT</h5>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('network/auth/' . encrypt_url('isotlpage')); ?>">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h6 class="card-title">form Edit OLT</h6>
                    <hr>
                </div>
                <div class="card-body">
                    <form id="send_data" class="forms-sample myForm">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-uppercase">OLT ID</label>
                                    <input type="hidden" class="form-control" name="id" id="id" value="<?= $list->Id; ?>" required />
                                    <input type="text" class="form-control" name="oltid" id="oltid" value="<?= $list->oltid; ?>" required />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-uppercase">oltinterface</label>
                                    <input type="text" class="form-control text-capitalize" value="<?= $list->oltinterface; ?>" required name="oltinterface" id="oltinterface" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-uppercase">intclientno</label>
                                    <input type="text" class="form-control text-capitalize" value="<?= $list->intclientno; ?>" required name="intclientno" id="intclientno" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-uppercase">ontid</label>
                                    <select name="ontid" id="ontid" class="form-control text-capitalize">
                                        <?php foreach ($ont as $data_ont) { ?>
                                            <option value="<?= $data_ont['ont'] ?>" <?= $data_ont['ont'] == $list->ontid ? 'selected' : ''; ?>> <?= $data_ont['ont'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <!-- <input type="text" class="form-control text-capitalize" value="<?= $list->ontid; ?>" name="ontid" id="ontid"/> -->
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group form-row">
                            <button class="btn btn-success" id="btn_upload" type="submit">
                                <i class="icon icon-check icon-fw icon-lg"></i>
                                Proses Update
                            </button>
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
                url: "<?= base_url('network/auth/' . encrypt_url('isupdateolt')); ?>",
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
                        if (data.status == 200) {
                            window.location.href = '<?= base_url('network/auth/' . encrypt_url('isoltpage')); ?>';
                        }
                    });
                }
            });
        });
    });
</script>