<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HOKALA |
        <?= $page_title; ?>
    </title>
    <!--favicon-->
    <link rel="icon" href="<?= base_url(); ?>assets/images/favicon-32x32.png" type="image/png">

    <!--plugins-->
    <link href="<?= base_url(); ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/plugins/metismenu/metisMenu.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/plugins/metismenu/mm-vertical.css">
    <!--bootstrap css-->
    <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!-- Option 1: Include in HTML -->
    <!--main css-->
    <link href="<?= base_url(); ?>assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="<?= base_url(); ?>sass/main.css" rel="stylesheet">
    <link href="<?= base_url(); ?>sass/dark-theme.css" rel="stylesheet">
    <link href="<?= base_url(); ?>sass/responsive.css" rel="stylesheet">

</head>

<body>

    <div class="section-authentication-cover">
        <div class="">
            <div class="row g-0">
                <div
                    class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex border-end">
                    <div class="card rounded-0 mb-0 border-0 shadow-none bg-transparent">
                        <div class="card-body"><img src="<?= base_url(); ?>assets/images/auth/login1.png"
                                class="img-fluid auth-img-cover-login" width="650" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                    <div class="card rounded-0 m-3 mb-0 border-0 shadow-none">
                        <div class="card-body p-sm-5">
                            <img src="<?= base_url(); ?>assets/images/logo1.png" class="mb-4" width="145" alt="">
                            <p class="mb-0">Enter your credentials to access your account</p>
                            <div class="form-body mt-4">
                                <form class="row g-3" action="<?= base_url();?>Home/login" method="post">

                                    <div class="col-12"><label for="inputEmailAddress" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>

                                    <div class="col-12">
                                        <label for="inputChoosePassword" class="form-label">Password</label>
                                        <div class="input-group" id="show_hide_password">
                                            <input type="password" class="form-control" id="password" name="password" required>
                                            <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="d-grid"><button type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </div>
                                    <?php if ($this->session->flashdata('message')) {
                                        ?>
                                        <div class="alert alert-border-danger alert-dismissible fade show">
                                            <div class="d-flex align-items-center">
                                                <div class="font-35 text-danger"><span
                                                        class="material-icons-outlined fs-2">report_gmailerrorred</span>
                                                </div>
                                                <div class="ms-3">
                                                    <h6 class="mb-0 text-danger">
                                                        <?= $this->session->flashdata('message');
                                                        ?>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }

                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#show_hide_password a").on('click', function (event) {
                event.preventDefault();

                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bi-eye-slash-fill");
                    $('#show_hide_password i').removeClass("bi-eye-fill");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bi-eye-slash-fill");
                    $('#show_hide_password i').addClass("bi-eye-fill");
                }
            }
            );

            setTimeout(function () {
                if (document.querySelector('.alert')) {
                    document.querySelector('.alert').style.display = 'none';
                }
            }, 5000);
        }
        );
    </script>
</body>

</html>