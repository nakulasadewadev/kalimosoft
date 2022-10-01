<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0 text-uppercase">Produk</h5>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('product/auth/' . encrypt_url('isproduct')); ?>">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
        </ol>
    </nav>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h6 class="card-title">form tambah produk</h6>
                    <hr>
                </div>
                <div class="card-body">
                    <form id="send_data" class="forms-sample myForm">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Kode</label>
                                    <input type="text" class="form-control" name="kode" id="kode" required />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Nama</label>
                                    <input type="text" class="form-control text-capitalize" required name="nama" id="nama" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Harga</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                        </div>
                                        <input type="text" name="harga" id="harga" class="form-control" placeholder="Harga..." aria-label="Biaya Lain" aria-describedby="basic-addon1" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group form-row">
                            <button class="btn btn-success" id="btn_upload" type="submit">
                                <i class="icon icon-check icon-fw icon-lg"></i>
                                Proses
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
                url: "<?php echo base_url('product/auth/' . encrypt_url('isprosesadd')); ?>",
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
                            $(".myForm")[0].reset();
                            window.location.href = "<?= base_url('product/auth/' . encrypt_url('isproduct')); ?>";
                        }
                    });
                }
            });
        });
    });
</script>