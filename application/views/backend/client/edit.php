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

<!-- MODAL KTP -->
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
<div class="animate__animated animate__fadeInUp">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h5 class="mb-3 mb-md-0">Client</h5>
        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('client/auth/'); ?><?php echo encrypt_url('isclient'); ?>">Data</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
    <?php foreach ($list as $ls) : ?>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">data customer</h6>
                        <hr>
                        <form class="forms-sample myForm" method="POST" action="<?php echo base_url('client/auth/' . encrypt_url('isupdate')); ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">NIK / ID Identitas</label>
                                        <input type="hidden" name="cid" id="cid" class="form-control" value="<?php echo $ls['cid']; ?>">
                                        <input type="number" class="form-control" value="<?php echo $ls['nik']; ?>" minlength="13" name="nik" id="nik" required />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Upload Scan KTP</label>
                                        <input type="file" class="form-control" name="ktp" id="ktp" accept="image/*" />
                                    </div>
                                    <div class="form-group">
                                        <?php if (!empty($ls['ktp'])) { ?>
                                            <a href="#" data-path="<?= $ls['ktp'] ?>" data-cid="<?= $ls['cid'] ?>" class="lihat-ktp"><i data-feather="credit-card" class="icon-sm mr-2"></i> Lihat KTP</a>
                                        <?php  } ?>
                                    </div>


                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Nama Lengkap</label>
                                        <input type="text" class="form-control text-capitalize" required name="name" id="name" value="<?php echo $ls['name']; ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">TTL</label>
                                        <input type="text" class="form-control text-capitalize" required name="ttl" id="ttl" value="<?php echo $ls['ttl']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Provinsi</label>
                                        <select name="provinsi" id="provinsi" class="select2 provinsi" required>
                                            <?php foreach ($provinsi as $prov) { ?>
                                                <option value="<?= $prov->id ?>" <?= $prov->id == $ls['provinsi'] ? 'selected' : ''; ?>><?= $prov->nama ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Kota / Kabupaten</label>
                                        <select name="kota" id="kota" class="select3 kabupaten" require>
                                            <option value='<?php echo $ls['kota']; ?>'>
                                                <?php echo $this->db->get_where('kota_kabupaten', array('id' => $ls['kota']))->row()->nama; ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Kecamatan</label>
                                        <select name="kecamatan" class="select4 kecamatan" id="kecamatan" required>
                                            <option value='<?php echo $ls['kecamatan']; ?>'>
                                                <?php echo $this->db->get_where('kecamatan', array('id' => $ls['kecamatan']))->row()->nama; ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">Kelurahan / Desa</label>
                                        <select name="kelurahan" class="select5 desa" id="kelurahan" required>
                                            <option value='<?php echo $ls['kelurahan']; ?>'>
                                                <?php echo $this->db->get_where('kelurahan', array('id' => $ls['kelurahan']))->row()->nama; ?>
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Alamat</label>
                                        <textarea name="address" id="address" rows="3" class="form-control" required><?php echo $ls['address']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">No.Hanphone</label>
                                        <input type="number" class="form-control" minlength="11" name="handphone" id="handphone" value="<?php echo $ls['handphone']; ?>" required />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Profesi</label>
                                        <input type="text" class="form-control text-uppercase" required name='profession' value="<?php echo $ls['profession']; ?>" id='profession' />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="<?php echo $ls['email']; ?>" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">MAP</label>
                                        <input type="text" class="form-control text-capitalize" name="location" id="location" value="<?php echo $ls['location']; ?>" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Status</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="1" <?= $ls['status'] == 1 ? 'selected' : ''; ?>>Member</option>
                                            <option value="2" <?= $ls['status'] == 2 ? 'selected' : ''; ?>>Prospective</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Keterangan</label>
                                        <textarea name="note" id="note" rows="3" class="form-control"><?php echo $ls['note']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group form-row">
                                <button class="btn btn-success" id="btn_upload" type="submit">
                                    <i class="icon icon-check icon-fw icon-lg"></i>
                                    Update Data
                                </button>
                            </div>
                        </form>


                    </div>
                </div>

            </div>

        </div>
    <?php endforeach; ?>

</div>



<script type="text/javascript">
    $(document).ready(function() {
        $(".lihat-ktp").on('click', function() {
            var path = $(this).attr('data-path');
            var cid = $(this).attr('data-cid');

            //var long= $(this).attr('data-long');
            $("#ktp").modal('show');
            var html = '<img src="<?= base_url('uploads/ktp/') ?>' + cid + '/' + path + '" alt="KTP" class="img-fluid">';
            $(".bodymap").html(html);
        });

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