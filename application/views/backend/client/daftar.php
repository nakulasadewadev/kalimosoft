<!-- NOTIF -->
<?php
if ($this->session->flashdata('msg')) {
    $data = $this->session->flashdata('msg');
?>
    <script type="text/javascript">
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
        });

        Toast.fire({
            icon: "<?= $data['title'] ?>",
            title: "<?= $data['message'] ?>"
        }).then(function() {
            if ("<?= $data['status'] ?>" == 200) {
                $(".myForm")[0].reset();
                window.location.href = "<?= base_url('client/auth/' . encrypt_url('isclient')); ?>";
            }
        });
    </script>
    <!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
<?php } ?>
<!-- END NOTIF -->

<div class="animate__animated animate__fadeInUp">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h5 class="mb-3 mb-md-0">Client</h5>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Data</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registrasi</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h6 class="card-title">registrasi pelanggan</h6>
                        <hr>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo base_url('client/auth/' . encrypt_url('isprosesadd')); ?>" method="POST" class="forms-sample myForm" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">NIK / ID Identitas</label>
                                        <input type="number" class="form-control" min="13" name="nik" id="nik" required />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Scan KTP</label>
                                        <input type="file" class="form-control" name="ktp" id="ktp" accept="image/*" required />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Nama Lengkap</label>
                                        <input type="text" class="form-control text-capitalize" required name="name" id="name" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">TTL</label>
                                        <input type="text" class="form-control text-capitalize" required name="ttl" id="ttl" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Provinsi</label>
                                        <select name="provinsi" id="provinsi" class="select2 provinsi" required>
                                            <option value="">-select-</option>
                                            <?php
                                            foreach ($provinsi as $prov) {
                                                echo '<option value="' . $prov->id . '">' . $prov->nama . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Kota / Kabupaten</label>
                                        <select name="kota" id="kota" class="select3 kabupaten" require>
                                            <option value=''>-Select Kota/Kabupaten-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Kecamatan</label>
                                        <select name="kecamatan" class="select4 kecamatan" id="kecamatan" required>
                                            <option value=''>-Select Kecamatan-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Kelurahan / Desa</label>
                                        <select name="kelurahan" class="select5 desa" id="kelurahan" required>
                                            <option value=''>-Select Kelurahan / Desa-</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Alamat</label>
                                        <textarea name="address" id="address" rows="3" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">No.Hanphone</label>
                                        <input type="number" class="form-control" minlength="11" name="handphone" id="handphone" required />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Profesi</label>
                                        <input type="text" class="form-control text-uppercase" required name="profession" id="profession" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Id Telegram</label>
                                        <input type="text" class="form-control" name="telegram" id="telegram" required />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">MAP</label>
                                        <input type="text" class="form-control text-capitalize" name="location" id="location" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="">-Pilih-</option>
                                            <option value="1">Member</option>
                                            <option value="2">Prospective</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Keterangan</label>
                                        <textarea name="note" id="note" rows="3" class="form-control"></textarea>
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
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".select2").select2();
        $(".select3").select2();
        $(".select4").select2();
        $(".select5").select2();

        $(".provinsi").change(function() {
            var url = "<?php echo site_url(); ?>client/add_ajax_kab/" + $(this).val();
            $('.kabupaten').load(url);
            return false;
        });

        $(".kabupaten").change(function() {
            var url = "<?php echo site_url('client/add_ajax_kec'); ?>/" + $(this).val();
            $('.kecamatan').load(url);
            return false;
        });

        $(".kecamatan").change(function() {
            var url = "<?php echo site_url('client/add_ajax_des'); ?>/" + $(this).val();
            $('.desa').load(url);
            return false;
        });

    });
</script>