<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0 text-uppercase">PROFILE</h5>
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
</div>
<?php foreach($list as $ls):?>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Profile</h6>
                    <hr>
                    <form id="send_data" class="forms-sample myForm">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-uppercase">NIK</label>
                                    <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $ls['idadminuser'];?>" required/>
                                    <input type="text" class="form-control" name="nik" id="nik" value="<?php echo $ls['nik'];?>" required readonly/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-uppercase">Nama lengkap</label>
                                    <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $ls['nama'];?>" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-uppercase">email</label>
                                    <input type="text" class="form-control" name="email" id="email" value="<?php echo $ls['email'];?>" required/>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group form-row">
                            <button class="btn btn-success" id="btn_upload" type="submit">
                                <i class="icon icon-check icon-fw icon-lg"></i>
                                Proses Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Ubah Password</h6>
                    <hr>
                    <form id="send_password" class="forms-sample myForm">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-uppercase">password baru</label>
                                    <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $ls['idadminuser'];?>" required/>
                                    <input type="password" id="txtNewPassword" minlength="6" class="form-control pass" placeholder="Enter passward" name="pass">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label text-uppercase">konfirm password</label>
                                    <input type="password" id="txtConfirmPassword" class="form-control konfirm" placeholder="Confirm Passward" name="confpass">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="registrationFormAlert" style="color:red;" id="CheckPasswordMatch">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group form-row" id="btn-password">
                            <button class="btn btn-success" id="btn_upload" type="submit">
                                <i class="icon icon-check icon-fw icon-lg"></i>
                                Proses Update
                            </button>
                        </div>
                    <form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach;?>

<script type="text/javascript">
    function checkPasswordMatch() {
        var password = $("#txtNewPassword").val();
        var confirmPassword = $("#txtConfirmPassword").val();
        if (password != confirmPassword){
            $("#CheckPasswordMatch").html("Passwords does not match!");
            $('#btn-password *').prop('disabled', true);
        }    
        else{
            $("#CheckPasswordMatch").html("Passwords match.");
            $('#btn-password *').prop('disabled', false);
        }
    }
    $(document).ready(function () {
        $('#btn-password *').prop('disabled', true);
        $("#txtConfirmPassword").keyup(checkPasswordMatch);
        var pass    = $(".pass").val();
        var konfirm = $(".konfirm").val();
        if(pass || konfirm == null){
            $('#btn-password *').prop('disabled', true);
        }

        $("#send_data").submit(function(ev){
            ev.preventDefault();
            $.ajax({
                type:"POST",
                url:"<?php echo base_url('profile/auth/'.encrypt_url('isupdateprofile'));?>",
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
                        icon: data.icon,
                        title: data.title
                    }).then(function(){
                        if(data.status == 200){
                            $(".myForm")[0].reset();
                            window.location.reload();
                        }
                    });
                }
            });
        });

        $("#send_password").submit(function(ev){
            ev.preventDefault();
            $.ajax({
                type:"POST",
                url:"<?php echo base_url('profile/auth/'.encrypt_url('isupdatepassword'));?>",
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
                        icon: data.icon,
                        title: data.title
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