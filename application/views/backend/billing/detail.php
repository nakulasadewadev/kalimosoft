<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">Billing</h5>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('billing/auth/'.encrypt_url('isbilling'));?>">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>
</div>
<?php
    $setting = $this->db->get('setting')->result_array();
    foreach($setting as $s){
        $alamat = $s['alamat'];
        $kota   = $this->db->get_where('kota_kabupaten',array('id'=>$s['kota']))->row()->nama;
        $nmkota = strtolower($kota);
        $city   = ucwords($nmkota);
        $tlpn   = $s['phone'];
        $email  = $s['email'];
        $wa     = $s['whatsapp'];
     }
?>
<?php foreach($list as $ls):?>
    <div class="card">
        <div class="card-body">
            <div class="container-fluid d-flex justify-content-between">
                <div class="col-lg-6 pl-0">
                    <a href="#" class="noble-ui-logo d-block mt-3">Kalimo<span>Soft</span></a>
                    <p class="text-capitalize"><?php echo $alamat;?>,<br> <?php echo $city;?>
                    <p>Phone : <?php echo $tlpn;?> / E-mail : <?php echo $email;?></p>
                    <p>Whatsapp : <?php echo $wa;?></p>
                </div>
                <div class="col-lg-3 pr-0">
                    <h4 class="font-weight-medium text-uppercase text-right mt-4 mb-2">invoice</h4>
                    <h6 class="text-right mb-5 pb-4">No : <?php echo $number;?> <br>
                    <p>Periode : <?php echo date('M-Y');?> </p> <br>
                    <p>To : <?php $member = $this->db->get_where('dbcustomer',array('cid'=>$ls['client']))->row()->name;
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
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody >
                            <tr>
                                <td><?php echo $ls['netid'];?></td>
                                <td class="text-wrap">
                                    <?php 
                                        $alamat = $this->db->get_where('dbnetwork',array('netid'=>$ls['netid']))->row()->address;
                                        echo ucwords($alamat);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        $product = $this->db->get_where('product',array('noproduct'=>$ls['product']))->row()->kode;
                                        echo strtoupper($product);
                                    ?>
                                </td>
                                <td>
                                    <?php echo date('d-m-Y H:i:s',strtotime($ls['end_at']));?>
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
                                            <td class="text-right">Rp  <?php echo number_format($ls['bill'],0,',','.');?> 
                                                <input type="hidden" name="noid" id="noid" value="<?php echo $number;?>"/>
                                                <input type="hidden" name="netid" id="netid" value="<?php echo $ls['netid'];?>"/>
                                                <input type="hidden" name="client" id="client" value="<?php echo $ls['client'];?>"/>
                                                <input type="hidden" name="period" id="period" value="<?php echo $ls['period'];?>"/>
                                                <input type="hidden" name="product" id="product" value="<?php echo $ls['product'];?>"/>
                                                <input type="hidden" name="bill" id="bill" value="<?php echo $ls['bill'];?>" onkeyup="getval();"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Potongan</td>
                                            <td class="text-right">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                                    </div>
                                                    <input type="text" name="potongan" id="potongan" class="form-control" placeholder="Potongan Pembayaran ..." 
                                                    aria-label="Biaya Lain" aria-describedby="basic-addon1" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);getval();">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-800">Biaya Lainnya</td>
                                            <td class="text-bold-800 text-right">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                                    </div>
                                                    <input type="text" name="biayalain" id="biayalain" class="form-control" placeholder="Biaya Lainnya ..." 
                                                    aria-label="Biaya Lain" aria-describedby="basic-addon1" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);getval();">
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="infoku">
                                            <tr>
                                                <td class="text-bold-800">Info Biaya Lainnya</td>
                                                <td class="text-bold-800 text-right">
                                                    <textarea name="infolain" id="infolain" rows="3" class="form-control"></textarea>
                                                </td>
                                            </tr>
                                        </div>
                                        <tr class="bg-light">
                                            <td class="text-bold-800">Total Tagihan</td>
                                            <td class="text-bold-800 text-right">
                                                <span> Rp <span class="total_tagihan"></span> </span>
                                                <input name="total_bayar" id="total_bayar" class="form-control total_bayar" type="hidden" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"/>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid w-100">
                        <button type="submit" class="btn btn-primary float-right mt-4 ml-2 btn-kirim"><i data-feather="send" class="mr-3 icon-md"></i>Send Invoice</button>
                        <button type="button" href="#" class="btn btn-outline-primary float-right mt-4 btn-cetak"><i data-feather="printer" class="mr-2 icon-md"></i>Print</button>
                    </div>
                </div>
            </form>
        </div>
    </div>        
<?php endforeach;?>


<script type="text/javascript">
    $(document).ready(function(){
        getval();
        $(".infoku").hide();
        $("#send").submit(function(ev){
            ev.preventDefault();
            $.ajax({
                type:"POST",
                url:"<?= base_url('billing/auth/'.encrypt_url('isaddinvoice'));?>",
                data:new FormData(this),
                dataType:"JSON",
                processData:false,
                contentType:false,
                async:false,
                cache:false,
                success:function(data){
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
                    }).then(function(){
                        if(data.status == 200){
                            $(".myForm")[0].reset();
                            window.location.href="<?php echo base_url('invoice/auth/'.encrypt_url('isinvoice'));?>"
                        }
                    });
                }
            })
        });
    });
    function getval(val){
        var hpp    = $("#potongan").val();
        var margin = $("#biayalain").val();
        var tagihan= $("#bill").val();

        if(margin == ''){
            $(".infolain").hide();
        }else{
            $(".infolain").show();
        }

        $.ajax({
            type:"POST",
            url:"<?php echo base_url('billing/hitung');?>",
            data:{hpp:hpp,margin:margin,tagihan:tagihan},
            dataType:"JSON",
            success:function(data){
                console.log(data);
                $("#total_bayar").val(data);
                $(".total_tagihan").html(data);
            }
        });
    }
</script>