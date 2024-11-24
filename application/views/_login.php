<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HOKALA | <?= $page_title; ?></title>
    <!--favicon-->
    <link rel="icon" href="<?= base_url(); ?>assets/images/favicon-32x32.png" type="image/png">

    <!--plugins-->
    <link href="<?= base_url(); ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <!--bootstrap css-->
    <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!--main css-->
    <link href="<?= base_url(); ?>assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="<?= base_url(); ?>sass/main.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .card {
            border-radius: 15px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            padding: 10px 15px;
            border: 1px solid #ced4da;
            border-radius: 10px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert {
            border-radius: 10px;
            font-size: 14px;
        }

        .input-group-text {
            cursor: pointer;
            background-color: transparent;
            border-left: none;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <img src="<?= base_url(); ?>assets/images/logo1.png" width="120" alt="Logo">
                <p class="mt-3">Enter your credentials to access your account</p>
            </div>
            <form action="<?= base_url(); ?>Home/login" method="post" class="mt-4">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group" id="show_hide_password">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <span class="input-group-text"><i class="bi bi-eye-slash-fill"></i></span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <?php if ($this->session->flashdata('message')): ?>
                    <div class="alert alert-danger mt-3">
                        <?= $this->session->flashdata('message'); ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#show_hide_password .input-group-text").on('click', function () {
                const passwordInput = $("#password");
                const icon = $(this).find("i");

                if (passwordInput.attr("type") === "password") {
                    passwordInput.attr("type", "text");
                    icon.removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
                } else {
                    passwordInput.attr("type", "password");
                    icon.removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
                }
            });

            setTimeout(() => $('.alert').fadeOut(), 5000);
        });
    </script>
</body>

</html>
