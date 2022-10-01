<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">NetWork</h5>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('network/auth/' . encrypt_url('isdatanetwork')); ?>">Data</a></li>
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

<div class="card">
    <div class="card-body">
        <div class="container-fluid d-flex justify-content-between">
            <div class="col-lg-6 pl-0">
                <a href="#" class="noble-ui-logo d-block mt-3">Kalimo<span>Soft</span></a>
                <p class="text-capitalize"><?= $alamat; ?>,<br> <?= $city; ?>
                <p>Phone : <?= $tlpn; ?> / E-mail : <?= $email; ?></p>
                <p>Whatsapp : <?= $wa; ?></p>
            </div>
            <div class="col-lg-3 pr-0">
                <h4 class="font-weight-medium text-uppercase text-right mt-4 mb-2">NetWork</h4>
                <h6 class="text-right mb-5 pb-4">Net ID :<?= $network->netid; ?></h6>
            </div>
        </div>

        <div class="container-fluid mt-5 d-flex justify-content-center w-100">
            <div class="table-responsive w-100">
                <table class="table ">
                    <thead class="table-info">
                        <tr>
                            <th>Client</th>
                            <th>No.Tlpn</th>
                            <th>Alamat</th>
                            <th>Profesi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?= ucwords($customer->name); ?>
                            </td>
                            <td>
                                <?= $customer->handphone; ?>
                            </td>
                            <td>
                                <?= ucwords($alamat_cust); ?>
                            </td>
                            <td>
                                <?= ucwords($customer->profession); ?>
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
                            <th>produk</th>
                            <th>kode</th>
                            <th>harga</th>
                            <th>keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?= strtoupper($network->nmproduk) ?>
                            </td>
                            <td>
                                <?= strtoupper($network->kode); ?>
                            </td>
                            <td>
                                <?= "Rp " . number_format($network->harga, 2, ',', '.');
                                ?>
                            </td>
                            <td>
                                <?= strtoupper($network->keterangan) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container-fluid mt-5 d-flex justify-content-center w-100">
            <div class="table-responsive w-100">
                <table class="table no-border">
                    <tbody>
                        <tr>
                            <td class="text-capitalize">register</td>
                            <td>
                                <?= date('d-m-Y H:i:s', strtotime($network->create_at)); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-capitalize">status</td>
                            <td>
                                <?php
                                if ($network->netstatus == '1') {
                                    echo '<span class="badge badge-pill badge-success">ONLINE</span>';
                                } else {
                                    echo '<span class="badge badge-pill badge-danger">OFFLINE</span>';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-capitalize">location</td>
                            <td><?= ucwords($network->address); ?></td>
                        </tr>
                        <!-- <tr>
                                <td class="text-capitalize">map</td>
                                <td><a href="<?= $network->location; ?>"><?= $network->location; ?></a></td>
                            </tr> -->
                        <tr>
                            <td class="text-capitalize">map</td>
                            <td>
                                <?php
                                // $lat  = $network->latitude;
                                // $long = $network->longitude;
                                $location = $network->location;
                                ?>
                                <iframe src='http://maps.google.com/maps?q="<?= $location; ?>"&z=16&output=embed' height="250" width="100%"></iframe>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-capitalize">ODC</td>
                            <td>
                                <?php
                                if ($network->odcport != null) {
                                    echo $network->odcport;
                                } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-capitalize">ODP</td>
                            <td>
                                <?= $network->odpport; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-capitalize">OLT</td>
                            <td><?= $network->oltid; ?></td>
                        </tr>
                        <tr>
                            <td class="text-capitalize">ONTID</td>
                            <td>
                                <?= $network->serialnumber ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-capitalize">LAYANAN</td>
                            <td>
                                <?= 'INTERNET : ' . $network->internet . ' | TV KABEL : ' . $network->tvkabel ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-capitalize">online date</td>
                            <td>
                                <?php
                                if ($network->onlinedate == null) {
                                    echo "-";
                                } else {
                                    echo date('d-m-Y', strtotime($network->onlinedate));
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>