<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Proses Payment</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h6 class="card-title">Cek Invoice</h6>
                </div>
                <form id="send_cari" class="myForm">
                    <label>Input No.Invoice</label>
                    <div class="input-group col-xs-12">
                        <select class="select1" name="noid" id="noid" onchange="getVal()">
                            <option value=""> Select No.Invoice </option>
                            <?php foreach ($list as $ls) { ?>
                                <option value="<?php echo $ls['no_invoice']; ?>">
                                    <?php echo $ls['no_invoice']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="submit">Cek Invoice</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="tampil">
    <?php
    $setting = $this->db->get('setting')->result_array();
    foreach ($setting as $s) {
        $alamat = $s['alamat'];
        $kota   = $this->db->get_where('kota_kabupaten', array('id' => $s['kota']))->row()->nama;
        $nmkota = strtolower($kota);
        $city   = ucwords($nmkota);
        $tlpn   = $s['phone'];
        $email  = $s['email'];
        $wa     = $s['whatsapp'];
    }
    ?>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="container-fluid d-flex justify-content-between">
                        <div class="col-lg-6 pl-0">
                            <a href="#" class="noble-ui-logo d-block mt-3">Kalimo<span>Soft</span></a>
                            <p class="text-capitalize"><?php echo $alamat; ?>,<br> <?php echo $city; ?>
                            <p>Phone : <?php echo $tlpn; ?> / E-mail : <?php echo $email; ?></p>
                            <p>Whatsapp : <?php echo $wa; ?></p>
                        </div>
                        <div class="col-lg-3 pr-0">
                            <h4 class="font-weight-medium text-uppercase text-right mt-4 mb-2">invoice</h4>
                            <h6 class="text-right mb-5 pb-4">No : <span id="noinvoice"></span> <br>
                                <p>Periode : <span id="period"></span> </p> <br>
                                <p>To : <span id="client"></span> </p>
                            </h6>
                        </div>
                    </div>
                    <div class="container-fluid mt-1 d-flex justify-content-center w-100">
                        <div class="table-responsive w-100">
                            <table class="table ">
                                <thead class="table-info">
                                    <tr>
                                        <th>Net.ID</th>
                                        <th>Lokasi Pemasangan</th>
                                        <th>Produk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span id="netid"></span></td>
                                        <td class="text-wrap"><span id="lokasi"></span></td>
                                        <td><span id="produk"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="container-fluid mt-5 w-100">
                        <div class="row">
                            <div class="col-md-6 ml-auto">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Tagihan</td>
                                                <td class="text-right">Rp <span id="bill"></span> </td>
                                            </tr>
                                            <tr>
                                                <td>Potongan</td>
                                                <td class="text-right">
                                                    Rp <span id="tax"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold-800">Biaya Lainnya</td>
                                                <td class="text-bold-800 text-right">
                                                    Rp <span id="lainnya"></span>
                                                </td>
                                            </tr>
                                            <div class="infoku">
                                                <tr>
                                                    <td class="text-bold-800">Info Biaya Lainnya</td>
                                                    <td class="text-bold-800 text-right">
                                                        <span id="info"></span>
                                                    </td>
                                                </tr>
                                            </div>
                                            <tr class="bg-light">
                                                <td class="text-bold-800">Total Tagihan</td>
                                                <td class="text-bold-800 text-right">
                                                    Rp <?php echo number_format($ls['totalbill'], 2, ',', '.'); ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label text-uppercase">Metode Pembayaran</label>
                                <select class="metod" id="metod" class="form-control" onchange="getMetode();">
                                    <option value="">-pilih-</option>
                                    <option value="1">Tunai</option>
                                    <option value="2">Transfer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tunai">
                        <form id="send_tunai">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">Nominal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                            </div>
                                            <input type="hidden" name="idinvoice" id="idinvoice" class="form-control" />
                                            <input type="hidden" name="netids" id="netids" class="form-control" />
                                            <input type="text" name="nominal" id="nominal" class="form-control" placeholder="Nominal Di Bayarkan ..." aria-label="Biaya Lain" aria-describedby="basic-addon1" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">Tgl.Pembayaran</label>
                                        <div class="input-group date datepicker dashboard-date mr-2 mb-2 mb-md-0 d-md-none d-xl-flex" id="dashboardDate">
                                            <span class="input-group-addon bg-transparent"><i data-feather="calendar" class=" text-primary"></i></span>
                                            <input type="text" class="form-control" name="tglbayar" id="tglbayar" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">Penerima</label>
                                        <select name="terima" id="terima" class="form-control">
                                            <option value="">-pilih-</option>
                                            <?php foreach ($users as $us) { ?>
                                                <option value="<?php echo $us['nik']; ?>"><?php echo ucwords($us['nama']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid w-100">
                                <button type="submit" class="btn btn-primary float-right mt-4 ml-2 btn-kirim"><i data-feather="send" class="mr-3 icon-md"></i>Proses Payment</button>
                                <br>
                            </div>
                        </form>
                    </div>
                    <div class="transfer">
                        <form id="send_transfer">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="hidden" name="idinvoice" class="form-control idinvoice" />
                                        <input type="hidden" name="noids" class="form-control noids" />
                                        <label class="control-label text-uppercase">Bank</label>
                                        <select name="terima" id="terima" class="form-control" required>
                                            <option value="">-pilih-</option>
                                            <option value="BCA">BCA</option>
                                            <option value="BRI">BRI</option>
                                            <option value="BNI">BNI</option>
                                            <option value="Mandiri">MANDIRI</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">No.Rek</label>
                                        <input type="text" name="rek" id="rek" class="form-control" required />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">Nominal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                            </div>
                                            <input type="text" name="jmlbayar" id="jmlbayar" class="form-control" placeholder="Nominal Di Bayarkan ..." aria-label="Biaya Lain" aria-describedby="basic-addon1" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label text-uppercase">Tgl.Transfer</label>
                                        <div class="input-group date datepicker dashboard-date mr-2 mb-2 mb-md-0 d-md-none d-xl-flex" id="enddate">
                                            <span class="input-group-addon bg-transparent"><i data-feather="calendar" class=" text-primary"></i></span>
                                            <input type="text" name="tgltransfer" id="tgltransfer" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid w-100">
                                    <button type="submit" class="btn btn-primary float-right mt-4 ml-2 btn-kirim"><i data-feather="send" class="mr-3 icon-md"></i>Proses Payment</button>
                                    <br>
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
    $(document).ready(function() {
        getVal();
        datefilter();
        $(".tunai").hide();
        $(".transfer").hide();
        $(".select1").select2();
        $("#send_cari").submit(function(ev) {
            ev.preventDefault();
            var noid = $("#noid").val();
            //console.log(noid);
            $.ajax({
                type: "POST",
                url: "<?= base_url('payment/cari'); ?>",
                data: {
                    noid: noid
                },
                dataType: "JSON",
                async: false,
                cache: false,
                success: function(data) {
                    console.log(data);
                    if (data.status == 200) {
                        $("#noinvoice").html(data.result['noid']);
                        $("#period").html(data.result['period']);
                        $("#client").html(data.result['client']);
                        $("#netid").html(data.result['netid']);
                        $("#produk").html(data.result['produk']);
                        $("#lokasi").html(data.result['lokasi']);
                        $("#bill").html(data.result['bill']);
                        $("#totbill").html(data.result['totbill']);
                        $("#tax").html(data.result['tax']);
                        $("#lainnya").html(data.result['lainnya']);
                        $("#info").html(data.result['infolain']);
                        $("#idinvoice").val(data.result['noid']);
                        $("#netids").val(data.result['netid']);
                        $(".idinvoice").val(data.result['noid']);
                        $(".netids").val(data.result['netid']);
                        $(".tampil").show();
                    } else {
                        $(".tampil").hide();
                    }
                }
            });
        });

        $("#send_tunai").submit(function(ev) {
            ev.preventDefault();
            Swal.fire({
                title: 'Konfirmasi ?',
                text: "Apakah Client Masih Memperpanjang Penggunaan NetWork ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'mr-2',
                confirmButtonText: 'Tetap Berlangganan',
                cancelButtonText: 'Berhenti Langganan',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('payment/auth/' . encrypt_url('isproses')); ?>",
                        data: new FormData(this),
                        dataType: "JSON",
                        processData: false,
                        contentType: false,
                        cache: false,
                        async: false,
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
                                    window.location.href = "<?php echo base_url('invoice/auth/' . encrypt_url('isinvoice')); ?>"
                                }
                            });
                        }
                    })
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire(
                        'Cancelled',
                        'Update Data Tidak Di Lakukan',
                        'error'
                    ).then(function() {
                        window.location.href = "<?php echo base_url('network/auth/' . encrypt_url('isdatanetwork')); ?>";
                    });
                }
            })

        });
    });

    function getMetode() {
        var pilih = $("#metod").val();
        if (pilih == 1) {
            $(".tunai").show();
            $(".transfer").hide();
        } else if (pilih == 2) {
            $(".tunai").hide();
            $(".transfer").show();
        } else {
            $(".tunai").hide();
            $(".transfer").hide();
        }
    }

    function getVal(val) {
        var nomer = $("#noid").val();
        if (nomer == '') {
            $(".tampil").hide();
        }
    }

    function datefilter() {
        if ($('#enddate').length) {
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            $('#enddate').datepicker({
                format: "dd-MM-yyyy",
                todayHighlight: true,
                autoclose: true
            });
            $('#enddate').datepicker('setDate', today);
        }
    }
</script>