<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">NetWork</h5>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('network/auth/' . encrypt_url('isdatanetwork')); ?>">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
</div>
<?php foreach ($list as $ls) : ?>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">edit network</h6>
                    <hr>
                    <form id="send" class="forms-sample myForm">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">PRODUK</label>
                                    <select class="form-control" name="produk" id="produk">
                                        <?php foreach ($produk as $pro) { ?>
                                            <option value="<?= $pro['noproduct']; ?>" <?= $pro['noproduct'] == $ls['productid'] ? 'selected' : ''; ?>>
                                                <?= $pro['kode']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Tanggal Online</label>
                                    <input type="date" id="onlinedate" class="form-control" name="onlinedate" id="onlinedate" value="<?= $ls['onlinedate'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">NET.ID</label>
                                    <input type="text" class="form-control" name="netid" id="netid" value="<?= $ls['netid']; ?>" readonly />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">User Name</label>
                                    <input type="text" class="form-control" name="username" id="username" value="<?= $ls['username']; ?>" readonly />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    <input type="text" class="form-control" name="password" id="password" value="<?= $ls['password']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Location</label>
                                    <input type="text" class="form-control text-capitalize" name="address" id="address" value="<?= $ls['address']; ?>" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Map</label>
                                    <input type="text" class="form-control" name="location" id="location" value="<?= $ls['location']; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Client</label>
                                    <?php
                                    $nama = $this->db->get_where('dbcustomer', array('cid' => $ls['cid']))->row()->name;
                                    $hp   = $this->db->get_where('dbcustomer', array('cid' => $ls['cid']))->row()->handphone;
                                    ?>
                                    <input type="text" class="form-control text-capitalize" name="client" id="client" value="<?= $nama; ?>" readonly />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">Hanphone</label>
                                    <input type="text" class="form-control" name="handphone" id="handphone" value="<?= $hp; ?>" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">ODC</label>
                                    <select name="odc" id="odc" class="select2">
                                        <?php foreach ($odc as $o) { ?>
                                            <option value="<?= $o['oltinterface']; ?>" <?= $o['oltinterface'] == $ls['odcid'] ? 'selected' : ''; ?>>
                                                <?= $o['oltinterface']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">PORT ODC</label>
                                    <input type="number" class="form-control" name="portodc" id="portodc" value="<?= $ls['port']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">ODP</label>
                                    <select name="odp" id="odp" class="select3">
                                        <?php foreach ($odp as $op) { ?>
                                            <option value="<?= $op['odpid']; ?>" <?= $op['odpid'] == $ls['odpid'] ? 'selected' : ''; ?>>
                                                <?= $op['odpcode']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label">PORT ODP</label>
                                    <input type="number" class="form-control" name="portodp" id="portodp" value="<?= $ls['odpport']; ?>">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">OLT</label>
                                    <select name="olt" id="olt" class="select4">
                                        <?php foreach ($olt as $ol) { ?>
                                            <option value="<?= $ol['oltid']; ?>" <?= $ol['oltid'] == $ls['oltid'] ? 'selected' : ''; ?>>
                                                <?= $ol['ontid']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label">ONT</label>
                                    <select name="ont" id="ont">
                                        <?php foreach ($ont as $on) { ?>
                                            <option value="<?= $on['ont']; ?>" <?= $on['ont'] == $ls['ontid'] ? 'selected' : ''; ?>>
                                                <?= $on['serialnumber']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">LAYANAN</label>
                                    <div class="row">
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="int" id="int" class="form-check-input int">
                                                    Internet
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="tvkabel" id="tvkabel" class="form-check-input tvkabel">
                                                    Tv Kabel
                                                </label>
                                            </div>
                                        </div>
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
<?php endforeach; ?>


<script type="text/javascript">
    $(document).ready(function() {

        document.getElementById('onlinedate').valueAsDate = new Date('<?= $ls["onlinedate"] ?>');

        $(".select5").select2();
        $(".select1").select2();
        $(".select2").select2();
        $(".select3").select2();
        $(".select4").select2();
        $("#send").submit(function(ev) {
            ev.preventDefault();
            var odc = $("#odc").val();
            var odp = $("#odp").val();
            var olt = $("#olt").val();
            var netid = $("#netid").val();
            var odcport = $("#portodc").val();
            var location = $("#location").val();
            var odpport = $("#portodp").val();
            var produk = $("#produk").val();
            var ont = $("#ont").val();
            var onlinedate = $("#onlinedate").val();



            if ($('input.ont').prop('checked')) {
                var int = 'Y';
            } else {
                var int = 'N';
            }

            if ($('input.tvkabel').prop('checked')) {
                var tv = 'Y';
            } else {
                var tv = 'N';
            }
            // var lat     = $("#latitude").val();
            // var long    = $("#longitude").val();
            if (odc == '' || odp == '' || olt == '') {
                Swal.fire({
                    title: 'Update NetWork ?',
                    text: "Data ODC , ODP , dan OLT Masih Belum Lengkap. Apakah Yakin Tetap Melakukan Proses Update!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'mr-2',
                    confirmButtonText: 'Ya, Tetap Proses!',
                    cancelButtonText: 'Tidak, Cancel Update!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('network/isupdatekosong'); ?>",
                            data: {
                                netid: netid,
                                location: location
                            },
                            dataType: "JSON",
                            success: function(data) {
                                console.log(data.id);
                                if (data.status == 200) {
                                    Swal.fire(
                                        'Update!',
                                        'Data NetWork Berhasil Di Update.',
                                        'success'
                                    ).then(function() {
                                        window.location.href = "<?= base_url('network/auth/' . encrypt_url('isdatanetwork')); ?>";
                                    });
                                }
                            }
                        });
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        Swal.fire(
                            'Cancelled',
                            'Update Data Tidak Di Lakukan',
                            'error'
                        ).then(function() {
                            window.location.href = "<?= base_url('network/auth/' . encrypt_url('isdatanetwork')); ?>";
                        });
                    }
                })
            } else {
                Swal.fire({
                    title: 'Update NetWork ?',
                    text: "Data ODC , ODP , dan OLT Sudah Lengkap. Apakah NetWork Juga Sudah ONLINE !",
                    icon: 'warning',
                    showCancelButton: true,
                    // confirmButtonClass: 'mr-2',
                    confirmButtonText: 'Ya, Sudah Online!',
                    cancelButtonText: 'Tidak, Belum Online!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('network/isupdateonline'); ?>",
                            data: {
                                netid: netid,
                                odc: odc,
                                odp: odp,
                                olt: olt,
                                ont: ont,
                                odcport: odcport,
                                location: location,
                                produk: produk,
                                int: int,
                                tv: tv,
                                odpport: odpport,
                                onlinedate: onlinedate
                            },
                            dataType: "JSON",
                            success: function(data) {
                                console.log(data);
                                if (data == 200) {
                                    Swal.fire(
                                        'SUCCESS!',
                                        'NetWork Sudah ONLINE.',
                                        'success'
                                    ).then(function() {
                                        window.location.href = "<?= base_url('network/auth/' . encrypt_url('isdatanetwork')); ?>";
                                    });
                                }
                                if (data == 204) {
                                    Swal.fire(
                                        'SUCCESS!',
                                        'Data Berhasil Di Update.',
                                        'success'
                                    ).then(function() {
                                        window.location.href = "<?= base_url('network/auth/' . encrypt_url('isdatanetwork')); ?>";
                                    });
                                }
                            }
                        });

                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('network/isupdateoffline'); ?>",
                            data: {
                                netid: netid,
                                odc: odc,
                                odp: odp,
                                olt: olt,
                                odcport: odcport,
                                location: location,
                                onlinedate: onlinedate
                            },
                            dataType: "JSON",
                            success: function(data) {
                                console.log(data);
                                Swal.fire(
                                    'Cancelled',
                                    'NetWork Berhasil Di Update, Namun Network Belum ONLINE',
                                    'error'
                                ).then(function() {
                                    window.location.href = "<?= base_url('network/auth/' . encrypt_url('isdatanetwork')); ?>";
                                });
                            }
                        });
                    }
                })
            }
        });
    });
</script>