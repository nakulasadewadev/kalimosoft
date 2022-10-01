<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title><?= $data->no_invoice; ?></title>

    <style>
        * {
            font-size: 15px;
            font-family: 'Times New Roman';
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: 250px;
            max-width: 250px;
            height: 250px;
            max-height: 250px;
        }

        td.description,
        th.description {
            width: 150px;
            max-width: 150px;
        }

        td.price,
        th.price {
            width: 100px;
            max-width: 100px;
            word-break: break-all;
        }

        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="ticket">
        <img id="barcode" class="img-fluid centered" />

        <p class="centered">
            Periode : <?= date('M-Y'); ?>
            <br>Net ID : <?= $data->netid; ?>
        </p>
        <p class="">
            <br>Kepada : <?= ucwords($this->db->get_where('dbcustomer', array('cid' => $data->client))->row()->name); ?>
            <br>Produk : <?= ucwords($this->db->get_where('product', array('noproduct' => $data->product))->row()->nmproduk); ?>
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
                    <td class="price">Rp. <?= number_format($data->bill, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td class="description">Potongan</td>
                    <td class="price">Rp. <?= number_format($data->tax, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                    <td class="description">Biaya Lainnya</td>
                    <td class="price">Rp. <?= number_format($data->other_bill, 2, ',', '.'); ?></td>
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
                    <td class="price">Rp. <?= number_format($data->totalbill, 2, ',', '.'); ?></td>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            JsBarcode("#barcode", "<?= $data->no_invoice; ?>", {
                width: 1.5,
                height: 50,
                fontSize: 15,
                font: 'Times New Roman'
            });
            window.print();
        });
    </script>
</body>

</html>