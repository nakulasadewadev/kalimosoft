<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">Application</h5>
    </div>
</div>
<?php foreach($list as $ls):?>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">general setting</h6>
                    <hr>
                    <form id="send_data" class="forms-sample myForm">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-capitalize">perusahaan</label>
                                    <input type="hidden" class="form-control text-capitalize" name="id" id="id" value="<?php echo $ls['idsetting'];?>" required/>
                                    <input type="text" class="form-control text-capitalize" name="perusahaan" id="perusahaan" value="<?php echo $ls['perusahaan'];?>" required/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-capitalize">Alamat</label>
                                    <textarea name="alamat" id="alamat" rows="3" class="form-control text-capitalize"><?php echo $ls['alamat'];?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Kota</label>
                                    <select name="kota" id="kota" class="select2 provinsi" required>
                                        <option value="<?php echo $ls['kota'];?>">
                                            <?php echo $this->db->get_where('kota_kabupaten',array('id'=>$ls['kota']))->row()->nama;?>
                                        </option>
                                        <?php 
                                            foreach($kota as $k)
                                            {
                                                echo "<option value=".$k['id'].">".$k['nama']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-capitalize">no. telephone</label>
                                    <input type="text" class="form-control text-capitalize" name="phone" id="phone" value="<?php echo $ls['phone'];?>" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">E-mail</label>
                                    <input type="text" class="form-control text-capitalize" name="email" id="email" value="<?php echo $ls['email'];?>" required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}"/>
                                </div>
                            </div>               
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">No.WA</label>
                                    <input type="number" class="form-control" minlength="11" name="whatsapp" id="whatsapp" value="<?php echo $ls['whatsapp'];?>"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Telegram</label>
                                    <input type="number" class="form-control" minlength="11" name="telegram" id="telegram" value="<?php echo $ls['telegram'];?>"/>
                                </div>
                            </div>           
                        </div>             
                        <hr>
                        <div class="form-group form-row">
                            <button class="btn btn-success" id="btn_upload" type="submit">
                                <i class="icon icon-check icon-fw icon-lg"></i>
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach;?>

<script type="text/javascript">
    $(document).ready(function(){
        $(".select2").select2();
        $(".select3").select2();
        $(".select4").select2();
        $(".select5").select2();

        $(".provinsi").change(function (){
            var url = "<?php echo site_url();?>client/add_ajax_kab/"+$(this).val();
            $('.kabupaten').load(url);
            return false;
        });

        $(".kabupaten").change(function (){
            var url = "<?php echo site_url('client/add_ajax_kec');?>/"+$(this).val();
            $('.kecamatan').load(url);
            return false;
        });

        $(".kecamatan").change(function (){
            var url = "<?php echo site_url('client/add_ajax_des');?>/"+$(this).val();
            $('.desa').load(url);
            return false;
        });

        $("#send_data").submit(function(ev){
            ev.preventDefault();
            $.ajax({
                type:"POST",
                url:"<?php echo base_url('setting/auth/'.encrypt_url('isupdatesetting'));?>",
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
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    
                    Toast.fire({
                        icon: data.title,
                        title: data.message
                    }).then(function(){
                        if(data.status == 200){
                            $(".myForm")[0].reset();
                            window.location.reload();
                        }
                    });
                }
            });
        });
    });
</script>