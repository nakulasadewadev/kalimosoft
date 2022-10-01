<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

function body_mail($data)
{

    return '<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    
        <style>
            table,
            th,
            td {
                border-left: none;
                border-right: none;
            }
        </style>
    </head>
    
    <body>
        <p>Kepada : ' . $data['client']->name . ' </p>
        <p>
        Invoice : ' . $data['invoice']->no_invoice . '<br>
        Periode : ' . date('M-Y') . '<br><br>
        Net ID : ' . $data['invoice']->netid . '<br>
        Produk : ' . $data['product']->nmproduk . '<br>
        Keterangan : ' . $data['product']->keterangan . '<br>
        </p>
        <br>
        <table border="1">
            <tr>
                <td>Tagihan</td>
                <td>Rp. ' . number_format($data['invoice']->bill, 2, ',', '.') . '</td>
            </tr>
            <tr>
                <td>Potongan</td>
                <td>Rp. ' . number_format($data['invoice']->tax, 2, ',', '.') . '</td>
            </tr>
            <tr>
                <td>Biaya Lainnya</td>
                <td>Rp. ' . number_format($data['invoice']->other_bill, 2, ',', '.') . '</td>
            </tr>
            <tr>
                <td>Info Biaya Lainnya</td>
                <td>' . $data['invoice']->info . '</td>
            </tr>
            <tr></tr>
            <tr>
                <td>Total Tagihan</td>
                <td>Rp. ' . number_format($data['invoice']->totalbill, 2, ',', '.') . '</td>
            </tr>
        </table>
    </body>
    
    </html>';
}
