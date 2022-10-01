<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Aplikasis</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/core/core.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/demo_1/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendors/sweetalert2/sweetalert2.min.css">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" />
</head>

<body class="sidebar-dark">
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            <div class="page-content d-flex align-items-center justify-content-center">
                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-8 col-xl-6 mx-auto">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-4 pr-md-0">
                                    <div class="auth-left-wrapper">
                                        <img src="<?php echo base_url(); ?>assets/images/loginimg.png" alt="login">
                                    </div>
                                </div>
                                <div class="col-md-8 pl-md-0">
                                    <div class="auth-form-wrapper px-4 py-5">
                                        <a href="#" class="noble-ui-logo d-block mb-2">Kalimo<span>Soft</span></a>
                                        <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your account.</h5>
                                        <!-- <form class="forms-sample" method="post" action="<?php echo base_url('login/auth/' . encrypt_url('islogins')); ?>" role="form"> -->
                                        <form id="send" class="forms-sample">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Password</label>
                                                <input type="password" class="form-control" name="password" id="password" autocomplete="current-password" placeholder="Password" required>
                                            </div>
                                            <div class="form-check form-check-flat form-check-primary">
                                                <label class="form-check-label">
                                                    <!-- <input type="checkbox" class="form-check-input">
                                                    Remember me
                                                </label> -->
                                            </div>
                                            <div class="mt-3">
                                                <!-- <a href="../../dashboard-one.html" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">Login</a> -->
                                                <button type="submit" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                                                    <i class="btn-icon-prepend" data-feather="unlock"></i>
                                                    Login
                                                </button>
                                            </div>
                                            <!-- <a href="register.html" class="d-block mt-3 text-muted">Not a user? Sign up</a> -->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/vendors/core/core.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/feather-icons/feather.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendors/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/template.js"></script>
    <script>
        $(document).ready(function() {
            $("#send").submit(function(ev) {
                ev.preventDefault();
                var email = $("#email").val();
                var password = $("#password").val();

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('login/auth/' . encrypt_url('islogins')); ?>",
                    data: {
                        email: email,
                        password: password
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data == '200') {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            })

                            Toast.fire({
                                    icon: 'success',
                                    title: 'Akses Di Terima'
                                })
                                .then(function() {
                                    window.location.href = "<?= site_url('main/dashboard'); ?>";
                                });
                        }
                        if (data == '201') {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'error',
                                title: 'Email Anda Salah, Silakan Coba Lagi'
                            });
                        }
                        if (data == '207') {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'error',
                                title: 'Akun Anda Terkunci, Silakan Hub Administrator'
                            });
                        }
                        if (data == '202') {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'error',
                                title: 'Password Anda Salah, Silakan Coba Lagi'
                            });
                        }
                        if (data == '206') {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'error',
                                title: 'Anda Salah Password 3x, Akun Anda Terkunci. Silakan Hub Administrator'
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>