<div class="animate__animated animate__fadeInUp">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h5 class="mb-3 mb-md-0">Pemasangan Baru</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h6 class="card-title">Cek Data Member</h6>
                    </div>
                    <form id="send_cari" class="myForm">
                        <label>Input NIK / ID Identitas</label>
                        <div class="input-group col-xs-12">
                            <input type="number" name="cari" id="cari" class="form-control cari" placeholder="NIK / ID Identitas .....">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="submit">Cek Member</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </div>
    <div id="tampil_produk">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center mb-3 mt-4">Pilih Produk</h4>
                    </div>
                    <div class="container">
                        <div class="row">
                            <?php foreach($produk as $p) { ?>
                                <div class="col-md-4 stretch-card grid-margin grid-margin-md-0 mt-10">
                                    <div class="card mb-3px">
                                        <div class="card-body">
                                            <input type="hidden" name="noproduk" id="noproduk" class="form-control produk" value="<?php echo $p['noproduct'];?>" readonly>
                                            <h5 class="text-center text-uppercase mt-3 mb-4"><?php echo $p['kode'];?></h5>
                                            <i data-feather="award" class="text-primary icon-xxl d-block mx-auto my-3"></i>
                                            <h4 class="text-center font-weight-light text-danger"><?php echo "Rp ".number_format($p['harga'],2,',','.');?> </h4>
                                            <p class="text-muted text-center mb-4 font-weight-light">per bulan</p>
                                            <h6 class="text-muted text-center mb-4 font-weight-normal text-capitalize"><?php echo $p['keterangan'];?></h6>
                                            <button class="btn btn-primary d-block mx-auto mt-4 btn-pilih" data-id="<?php echo $p['noproduct'];?>">PILIH</button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        
        $('#tampil_produk *').prop('disabled',true);
        $("#send_cari").submit(function(ev){
            ev.preventDefault();
            $.ajax({
                type:"POST",
                url:"<?php echo base_url('client/auth/'.encrypt_url('isfindid'));?>",
                data:new FormData(this),
                dataType:"JSON",
                processData:false,
                contentType:false,
                async:false,
                cache:false,
                success:function(data){
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top',
                        showConfirmButton: true,
                    });
                    
                    Toast.fire({
                        icon: data.title,
                        title: data.message
                    }).then(function(){
                        if(data.status != 200){
                            $(".myForm")[0].reset();
                            $('#tampil_produk *').prop('disabled',true);
                            window.location.href="<?php echo base_url('client/auth/'.encrypt_url('isregister'));?>";
                        }
                        if(data.status == 200){
                            $('#tampil_produk *').prop('disabled',false);
                        }
                    });
                }
            });
        });

        $(".btn-pilih").on('click',function(){
            console.log('pilih');
            var nomor  = $(this).attr('data-id');
            var id     = $(".cari").val();
            var nmproduk = window.btoa(nomor);
            var users  = window.btoa(id);
            window.location.href="<?php echo base_url('order/auth/'.encrypt_url('isorder'));?>/"+nmproduk+"/<?php echo encrypt_url('isaccessmyprivate');?>/"+users;
        });
    });

</script>