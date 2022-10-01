<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0 text-uppercase">ONT</h5>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('network/auth/' . encrypt_url('isontpage')); ?>">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">form edit ont</h6>
                <hr>
                <form id="send_data" class="forms-sample myForm">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label text-uppercase">serial number</label>
                                <input type="text" class="form-control" name="serial" id="serial" value="<?= $list->serialnumber ?>" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label text-uppercase">layanan</label>
                            </div>
                            <div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="int" id="int" <?= $list->internet == 1 ? 'checked' : ''; ?> class="form-check-input">
                                        Internet
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="tvkabel" id="tvkabel" <?= $list->tvkabel == 1 ? 'checked' : ''; ?> class="form-check-input">
                                        Tv Kabel
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group form-row">
                        <input type="hidden" name="idont" value="<?= $list->idont ?>">
                        <button class="btn btn-success btn-icon-text" id="btn_upload" type="submit">
                            <i class="btn-icon-prepend" data-feather="check-square"></i>
                            Proses
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#send_data").submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('network/auth/' . encrypt_url('isupdateont')); ?>",
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
                            window.location.href = "<?= base_url('network/auth/' . encrypt_url('isontpage')); ?>";
                        }
                    });
                }
            });
        });
    });
</script>