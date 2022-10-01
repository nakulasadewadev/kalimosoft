<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0 text-uppercase">data error</h5>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('setting/auth/'.encrypt_url('iserros'));?>">Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
</div>
<?php foreach($list as $ls):?>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">form edit error</h6>
                <form id="send_data" class="forms-sample myForm">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label text-uppercase">kode error</label>
                                <input type="text" class="form-control" name="errorcode" id="errorcode" value="<?php echo $ls['errorcode'];?>" readonly/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label text-uppercase">nama error</label>
                                <input type="text" class="form-control text-capitalize" required name="errorname" id="errorname" value="<?php echo $ls['errorname'];?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label text-uppercase">keterangan</label>
                                <textarea name="desk" id="desk" rows="3" class="form-control"><?php echo $ls['description'];?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label text-uppercase">catatan</label>
                                <textarea name="note" id="note" rows="3" class="form-control"><?php echo $ls['note'];?></textarea>
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
        $("#send_data").submit(function(ev){
            ev.preventDefault();
            $.ajax({
                type:"POST",
                url:"<?php echo base_url('setting/auth/'.encrypt_url('isupdateserror'));?>",
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
                            window.location.reload();
                        }
                    });
                }
            });
        });
    });
</script>