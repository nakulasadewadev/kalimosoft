<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">Order Pemasangan</h5>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <!-- <form method="post" enctype="multipart/form-data" action="<?= base_url('order/auth/' . encrypt_url('isprocess')); ?>"> -->
            <form id="kirim" class="myForm">
                <div class="card-body">
                    <div class="card-title">
                        <h6 class="card-title">form order pemasangan : </h6> <input name="nomor" id="nomor" value="<?php echo $nomor; ?>" class="form-control" readonly />
                        <hr>
                    </div>
                    <div id="wizardOrder">
                        <h2>Data Member</h2>
                        <section>
                            <?php foreach ($user as $u) : ?>
                                <?php
                                if ($u['provinsi'] != 0) {
                                    $prov = $this->db->get_where('provinsi', array('id' => $u['provinsi']))->row()->nama;
                                } else {
                                    $prov = '';
                                }

                                if ($u['kota'] != 0) {
                                    $kota = $this->db->get_where('kota_kabupaten', array('id' => $u['kota']))->row()->nama;
                                } else {
                                    $kota = '';
                                }

                                if ($u['kecamatan'] != 0) {
                                    $camat =  $this->db->get_where('kecamatan', array('id' => $u['kecamatan']))->row()->nama;
                                } else {
                                    $camat = '';
                                }

                                if ($u['kelurahan'] != 0) {
                                    $desa =  $this->db->get_where('kelurahan', array('id' => $u['kelurahan']))->row()->nama;
                                } else {
                                    $desa = '';
                                }
                                ?>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">NIK / ID Identitas</label>
                                            <input type="hidden" class="form-control text-uppercase" value="<?php echo $u['cid']; ?>" name="cid" id="cid" readonly />
                                            <input type="text" class="form-control" name="nik" id="nik" value="<?php echo $u['nik']; ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Nama Lengkap</label>
                                            <input type="text" class="form-control text-capitalize" name="nama" id="nama" value="<?php echo $u['name']; ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">No.Handphone</label>
                                            <input type="text" class="form-control text-capitalize" name="nohp" id="nohp" value="<?php echo $u['handphone']; ?>" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Alamat</label>
                                            <textarea name="alamat" id="alamat" rows="3" class="form-control" readonly><?php echo $u['address'] . " " . $desa . " , " . $camat . " , " . $kota . "-" . $prov; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </section>
                        <h2>Data Produk</h2>
                        <section>
                            <?php foreach ($produk as $pr) : ?>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Kode</label>
                                            <input type="hidden" class="form-control text-uppercase" value="<?php echo $pr['noproduct']; ?>" name="idproduct" id="idproduct" readonly />
                                            <input type="text" class="form-control text-uppercase" value="<?php echo $pr['kode']; ?>" name="kode" id="kode" readonly />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Nama</label>
                                            <input type="text" class="form-control text-uppercase" value="<?php echo $pr['nmproduk']; ?>" name="produk" id="produk" readonly />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Harga</label>
                                            <input type="email" class="form-control" value="<?php echo number_format($pr['harga'], 2, ',', '.'); ?>" name="harga" id="harga" readonly />
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </section>
                        <h2>Area Pasang</h2>
                        <section>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">net.id</label>
                                        <input type="text" class="form-control text-uppercase" value="<?php echo $netid; ?>" name="netid" id="netid" onkeyup="getVal();" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">username</label>
                                        <input type="text" class="form-control text-uppercase" value="<?php echo $netid; ?>" name="username" id="username" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">password</label>
                                        <input type="password" class="form-control text-uppercase" value="123456" name="password" id="password" onkeyup="getValPass();" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">ODC</label>
                                        <select class="form-control" name="odc" id="odc" required>
                                            <option value="">-pilih-</option>
                                            <?php foreach ($odc as $dc) { ?>
                                                <option value="<?php echo $dc['oltinterface']; ?>">
                                                    <?php echo $dc['oltinterface']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">ODP</label>
                                        <select class="form-control" name="odp" id="odp" required>
                                            <option value="">-pilih-</option>
                                            <?php foreach ($odp as $dp) { ?>
                                                <option value="<?php echo $dp['odpid']; ?>">
                                                    <?php echo $dp['odpcode']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">OLT</label>
                                        <select class="form-control" name="olt" id="olt">
                                            <option value="">-pilih-</option>
                                            <?php foreach ($olt as $dp) { ?>
                                                <option value="<?php echo $dp['oltid']; ?>">
                                                    <?php echo $dp['oltinterface']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">alamat pasang</label>
                                        <textarea name="almtpasang" id="almtpasang" class="form-control text-capitalize" rows="3" required placeholder="Isi Secara Lengkap Alamat Pemasangan Baru ..." onkeyup="getAlamat();"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">map</label>
                                        <textarea name="location" id="location" class="form-control text-capitalize" rows="3" required placeholder="Isi Secara Lengkap Alamat Pemasangan Baru ..." onkeyup="getAlamat();"></textarea>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">latitude</label>
                                        <textarea name="latitude" id="latitude" class="form-control" rows="3" placeholder="Isikan Latitude Sesuai Google Map ..." onkeyup="getMap();"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">longitude</label>
                                        <textarea name="longitude" id="longitude" class="form-control" rows="3" placeholder="Isikan Longitude Sesuai Google Map ..." onkeyup="getMap();"></textarea>
                                    </div>
                                </div> -->
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">informasi tambahan</label>
                                        <textarea name="note" id="note" class="form-control" rows="3" placeholder="Informasi Tambahan Jika Di Perlukan ..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <h2>Review</h2>
                        <section>
                            <h6 class="card-title">Data Member</h6>
                            <?php foreach ($user as $u) : ?>
                                <?php
                                if ($u['provinsi'] != 0) {
                                    $prov = $this->db->get_where('provinsi', array('id' => $u['provinsi']))->row()->nama;
                                } else {
                                    $prov = '';
                                }

                                if ($u['kota'] != 0) {
                                    $kota = $this->db->get_where('kota_kabupaten', array('id' => $u['kota']))->row()->nama;
                                } else {
                                    $kota = '';
                                }

                                if ($u['kecamatan'] != 0) {
                                    $camat =  $this->db->get_where('kecamatan', array('id' => $u['kecamatan']))->row()->nama;
                                } else {
                                    $camat = '';
                                }

                                if ($u['kelurahan'] != 0) {
                                    $desa =  $this->db->get_where('kelurahan', array('id' => $u['kelurahan']))->row()->nama;
                                } else {
                                    $desa = '';
                                }
                                ?>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">NIK / ID Identitas</label>
                                            <input type="hidden" class="form-control text-uppercase" value="<?php echo $u['cid']; ?>" name="cid" id="cid" readonly />
                                            <input type="text" class="form-control" name="nik" id="nik" value="<?php echo $u['nik']; ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Nama Lengkap</label>
                                            <input type="text" class="form-control text-capitalize" name="nama" id="nama" value="<?php echo $u['name']; ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">No.Handphone</label>
                                            <input type="text" class="form-control text-capitalize" name="nohp" id="nohp" value="<?php echo $u['handphone']; ?>" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Alamat</label>
                                            <textarea name="alamat" id="alamat" rows="3" class="form-control" readonly><?php echo $u['address'] . " " . $desa . " , " . $camat . " , " . $kota . "-" . $prov; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <hr>
                            <h6 class="card-title">Produk</h6>
                            <?php foreach ($produk as $pr) : ?>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Kode</label>
                                            <input type="hidden" class="form-control text-uppercase" value="<?php echo $pr['noproduct']; ?>" name="idproduct" id="idproduct" readonly />
                                            <input type="text" class="form-control text-uppercase" value="<?php echo $pr['kode']; ?>" name="kode" id="kode" readonly />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Nama</label>
                                            <input type="text" class="form-control text-uppercase" value="<?php echo $pr['nmproduk']; ?>" name="produk" id="produk" readonly />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">Harga</label>
                                            <input type="email" class="form-control" value="<?php echo number_format($pr['harga'], 2, ',', '.'); ?>" name="harga" id="harga" readonly />
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <h6 class="card-title">Data NetWork</h6>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">net.id</label>
                                        <div class="idnet"></div>
                                        <!-- <input type="text" class="form-control text-uppercase idnet" name="idnet" id="idnet" /> -->
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">username</label>
                                        <div class="idnet"></div>
                                        <!-- <input type="text" class="form-control text-uppercase" value="<?php echo $netid; ?>" name="username" id="username" /> -->
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">password</label>
                                        <div class="passuser"></div>
                                        <!-- <input type="password" class="form-control text-uppercase" value="123456" name="password" id="password" /> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">alamat pemasangan</label>
                                        <div class="almtpasang"></div>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">map pemasangan</label>
                                        <div class="mapgoogle"></div>
                                    </div>
                                </div> -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">latitude</label>
                                        <div class="latitude"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">longitude</label>
                                        <div class="longitude"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase"></label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">biaya administrasi</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                            </div>
                                            <input type="text" name="biaya" id="biaya" class="form-control" placeholder="Biaya Administrasi ..." aria-label="Biaya Lain" aria-describedby="basic-addon1" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase"></label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">biaya lainnya</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                            </div>
                                            <input type="text" name="biayalain" id="biayalain" class="form-control" placeholder="Biaya Lainnya ..." aria-label="Biaya Lain" aria-describedby="basic-addon1" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase"></label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">info biaya lain</label>
                                        <textarea name="infolain" id="infolain" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        getVal();
        getValPass();
        getAlamat();
        getMap();
        $(".select1").select2();
        $(".select2").select2();
        $(".select3").select2();

        $("#wizardOrder").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            onFinished: function(event, currentIndex) {
                event.preventDefault();
                var noid = $("#nomor").val();
                var netid = $("#netid").val();
                var cid = $("#cid").val();
                var user = $("#username").val();
                var pass = $("#password").val();
                var produk = $("#idproduct").val();
                var alamat = $("#almtpasang").val();
                var map = $("#map").val();
                var note = $("#note").val();
                var biaya = $("#biaya").val();
                var biayalain = $("#biayalain").val();
                var infolain = $("#infolain").val();
                var lokasi = $("#location").val();
                var odp = $("#odp").val();
                var odc = $("#odc").val();
                var olt = $("#olt").val();
                // var latitude    = $("#latitude").val();
                // var longitude   = $("#longitude").val();
                if (biaya == '') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top',
                        showConfirmButton: true,
                    })
                    Toast.fire({
                        icon: 'error',
                        title: 'Anda Belum Meng-inputkan Biaya Administrasi Pemasangan'
                    });
                } else if (alamat == '') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top',
                        showConfirmButton: true,
                    })
                    Toast.fire({
                        icon: 'error',
                        title: 'Anda Meng-inputkan Alamat Pemasangan. Silakan Di Inputkan Dahulu Alamat Pemasangan Secara Lengkap'
                    });
                } else if (map == '') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top',
                        showConfirmButton: true,
                    })
                    Toast.fire({
                        icon: 'error',
                        title: 'Mohon Untuk Informasikan Location Map Area Pemasangan Baru. Location Bisa Ambil Dari Google Map'
                    });
                } else {
                    myObj = {
                        "nomor": noid,
                        "netid": netid,
                        "cid": cid,
                        "username": user,
                        "password": pass,
                        "idproduct": produk,
                        "address": alamat,
                        "map": null,
                        "biaya": biaya,
                        "biayalain": biayalain,
                        "note": note,
                        "infolain": infolain,
                        "location": null,
                        "odc": odc,
                        "olt": olt,
                        "odp": odp
                    }
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('order/auth/' . encrypt_url('isprocess')); ?>",
                        data: myObj,
                        dataType: "JSON",
                        cache: false,
                        success: function(data) {
                            console.log(data.message);
                            Swal.fire({
                                title: data.message,
                                text: "Apakah Anda ingin menambahkan lagi?",
                                icon: data.icon,
                                showCancelButton: true,
                                confirmButtonText: 'Ya',
                                cancelButtonText: 'Tidak',
                            }).then((result) => {
                                if (result.value) {
                                    window.location.href = "<?php echo base_url('client/auth/' . encrypt_url('isaddlink')); ?>";

                                } else if (
                                    // Read more about handling dismissals
                                    result.dismiss === Swal.DismissReason.cancel
                                ) {
                                    window.location.href = "<?php echo base_url('network/auth/' . encrypt_url('isdatanetwork')); ?>";

                                }
                            });


                            // const Toast = Swal.mixin({
                            //     toast: true,
                            //     position: 'top',
                            //     showConfirmButton: true,
                            // })
                            // Toast.fire({
                            //     icon: data.title,
                            //     title: data.message
                            // }).then(function() {
                            //     window.location.href = "<?php echo base_url('client/auth/' . encrypt_url('isaddlink')); ?>";
                            // });
                        }
                    });
                }
            }
        });
    });

    function getVal(val) {
        var netid = $("#netid").val();
        $(".idnet").text(netid);
    }

    function getValPass(val) {
        var netpass = $("#password").val();
        $(".passuser").text(netpass);
    }

    function getAlamat(val) {
        var alamat = $("#almtpasang").val();
        $(".almtpasang").text(alamat);
    }

    function getMap(val) {
        var maps = $("#map").val();
        var long = $("#longitude").val();
        var lat = $("#latitude").val();
        $(".mapgoogle").text(maps);
        $(".latitude").text(lat);
        $(".longitude").text(long);
    }
</script>