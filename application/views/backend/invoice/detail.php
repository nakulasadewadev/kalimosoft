<style>
    #modalPrintPreview {
        font-size: 15px;
        font-family: 'Times New Roman';
    }

    .centered {
        text-align: center;
        align-content: center;
    }


    td.description,
    th.description {
        width: 350px;
        max-width: 350px;
    }

    td.price,
    th.price {
        width: 200px;
        max-width: 200px;
        word-break: break-all;
    }
</style>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">Invoice</h5>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('invoice/auth/' . encrypt_url('isinvoice')); ?>">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>
</div>
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
<?php foreach ($list as $ls) : ?>
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
                    <h6 class="text-right mb-5 pb-4">No : <?php echo $ls['no_invoice']; ?> <br>
                        <p>Periode : <?php echo date('M-Y'); ?> </p> <br>
                        <p>To : <?php $member = $this->db->get_where('dbcustomer', array('cid' => $ls['client']))->row()->name;
                                echo ucwords($member); ?></p>
                    </h6>

                </div>
            </div>

            <div class="container-fluid mt-5 d-flex justify-content-center w-100">
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
                                <td><?php echo $ls['netid']; ?></td>
                                <td class="text-wrap">
                                    <?php
                                    $alamat = $this->db->get_where('dbnetwork', array('netid' => $ls['netid']))->row()->address;
                                    echo ucwords($alamat);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $product = $this->db->get_where('product', array('noproduct' => $ls['product']))->row()->kode;
                                    echo strtoupper($product);
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <form id="send" class="myForm">
                <div class="container-fluid mt-5 w-100">
                    <div class="row">
                        <div class="col-md-6 ml-auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Tagihan</td>
                                            <td class="text-right">Rp <?php echo number_format($ls['bill'], 2, ',', '.'); ?></td>
                                            <input type="hidden" name="client" id="client" value="<?php echo $ls['client']; ?>" />
                                            <input type="hidden" name="no_invoice" id="no_invoice" value="<?php echo $ls['no_invoice']; ?>" />
                                            <input type="hidden" name="product" id="product" value="<?php echo $ls['product']; ?>" />
                                        </tr>
                                        <tr>
                                            <td>Potongan</td>
                                            <td class="text-right">
                                                Rp <?php echo number_format($ls['tax'], 2, ',', '.'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-800">Biaya Lainnya</td>
                                            <td class="text-bold-800 text-right">
                                                Rp <?php echo number_format($ls['other_bill'], 2, ',', '.'); ?>
                                            </td>
                                        </tr>
                                        <div class="infoku">
                                            <tr>
                                                <td class="text-bold-800">Info Biaya Lainnya</td>
                                                <td class="text-bold-800 text-right">
                                                    <textarea name="infolain" id="infolain" rows="3" class="form-control" readonly><?php echo $ls['info']; ?></textarea>
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
                    <div class="container-fluid w-100">
                        <?php
                        if ($ls['statinvoice'] == 1) { ?>
                            <button type="submit" class="btn btn-primary float-right mt-4 ml-2 btn-kirim"><i data-feather="send" class="mr-3 icon-md"></i>Re-Send Invoice</button>
                        <?php } ?>
                        <!-- <button type="button" href="#" class="btn btn-outline-primary float-right mt-4 btn-cetak"><i data-feather="printer" class="mr-2 icon-md"></i>Print</button> -->
                        <button type="button" class="btn btn-outline-primary float-right mt-4 btn-cetak" data-toggle="modal" data-target="#modalPrintPreview">
                            <i data-feather="printer" class="mr-2 icon-md"></i>Print
                        </button>

                        <div class="modal fade" id="modalPrintPreview" tabindex="-1" role="dialog" aria-labelledby="modalPrintPreviewTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <img id="barcode" class="img-fluid centered" />
                                        </div>

                                        <p class="centered">
                                            Periode : <?= date('M-Y'); ?>
                                            <br>Net ID : <?= $ls['netid']; ?>
                                        </p>
                                        <p class="">
                                            <br> Kepada : <?= ucwords($this->db->get_where('dbcustomer', array('cid' => $ls['client']))->row()->name); ?>
                                            <br> Produk : <?= ucwords($this->db->get_where('product', array('noproduct' => $ls['product']))->row()->nmproduk); ?>
                                        </p>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="description">
                                                        <hr>
                                                    </td>
                                                    <td class="price">
                                                        <hr>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="description">Tagihan</td>
                                                    <td class="price">Rp. <?= number_format($ls['bill'], 2, ',', '.'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="description">Potongan</td>
                                                    <td class="price">Rp. <?= number_format($ls['tax'], 2, ',', '.'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="description">Biaya Lainnya</td>
                                                    <td class="price">Rp. <?= number_format($ls['other_bill'], 2, ',', '.'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <hr>
                                                    </td>
                                                    <td>
                                                        <hr>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="description">TOTAL</td>
                                                    <td class="price">Rp. <?= number_format($ls['totalbill'], 2, ',', '.'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <hr>
                                                    </td>
                                                    <td>
                                                        <hr>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br><br>
                                        <?php if (!empty($admin)) { ?>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td class="description"><u>Operator</u></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="description">
                                                            <br>
                                                            <?= strtoupper($admin->nama); ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        <?php } ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a target="_blank" href="<?= base_url('invoice/print/' . encrypt_url($ls['no_invoice'])) ?>" class="btn btn-primary"><i data-feather="printer" class="mr-2 icon-md"></i>Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        //barcode
        JsBarcode("#barcode", "<?= $ls['no_invoice'] ?>", {
            width: 1.5,
            height: 50,
            fontSize: 15,
            font: 'Times New Roman'
        });


        getval();
        $(".infoku").hide();
        $("#send").submit(function(ev) {
            ev.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('invoice/auth/' . encrypt_url('resend_invoice')); ?>",
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
                            window.location.href = "<?php echo base_url('invoice/auth/' . encrypt_url('isinvoice')); ?>"
                        }
                    });
                }
            })
        });
    });

    function getval(val) {
        var hpp = $("#potongan").val();
        var margin = $("#biayalain").val();
        var tagihan = $("#bill").val();

        if (margin == '') {
            $(".infolain").hide();
        } else {
            $(".infolain").show();
        }

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('billing/hitung'); ?>",
            data: {
                hpp: hpp,
                margin: margin,
                tagihan: tagihan
            },
            dataType: "JSON",
            success: function(data) {
                console.log(data);
                $("#total_bayar").val(data);
                $(".total_tagihan").html(data);
            }
        });
    }
</script>