<style>
    @media print {
        .noPrint {
            display: none;
        }
    }
</style>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).outerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">Order Detail</h5>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('reporting/auth/' . encrypt_url('isreportclient')); ?>">Data Client</a></li>
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

<div class="card" id="print-area">
    <div class="card-body">
        <div class="container-fluid d-flex justify-content-between">
            <div class="col-lg-6 pl-0">
                <a href="#" class="noble-ui-logo d-block mt-3">Kalimo<span>Soft</span></a>
                <p class="text-capitalize"><?= $alamat; ?>,<br> <?= $city; ?>
                <p>Phone : <?= $tlpn; ?> / E-mail : <?= $email; ?></p>
                <p>Whatsapp : <?= $wa; ?></p>
            </div>
            <div class="col-lg-3 pr-0">
                <h4 class="font-weight-medium text-uppercase text-right mt-4 mb-2">ORDER</h4>
                <h6 class="text-right mb-5 pb-4">No. Order : <?= $order->noorder; ?></h6>
            </div>
        </div>

        <div class="container-fluid mt-5 d-flex justify-content-center w-100">
            <div class="table-responsive w-100">
                <table class="table ">
                    <thead class="table-info">
                        <tr>
                            <th class="w-20">Pelanggan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Nama
                            </td>
                            <td>
                                <?= ucwords($order->name); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                No. Telp
                            </td>
                            <td>
                                <?= $order->handphone; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>
                                <?= ucwords($order->address); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Profesi</td>
                            <td>
                                <?= ucwords($order->profession); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container-fluid mt-5 d-flex justify-content-center w-100">
            <div class="table-responsive w-100">
                <table class="table ">
                    <thead class="table-danger">
                        <tr>
                            <th class="w-20">produk</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Kode</td>
                            <td>
                                <?= strtoupper($order->kode); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Produk</td>
                            <td>
                                <?= strtoupper($order->nmproduk) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>
                                <?= strtoupper($order->keterangan) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Harga</td>
                            <td>
                                <?= "Rp " . number_format($order->harga, 2, ',', '.');
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt-5 d-flex justify-content-center w-100">
    <button target="_blank" class="btn btn-outline-primary float-right mt-4 noPrint" id="print" onclick="printDiv('print-area')"><i data-feather="printer" class="mr-2 icon-md"></i>Print</button>
</div>