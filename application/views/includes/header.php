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
   <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/plugins/simplebar/css/simplebar.css">
   <!--bootstrap css-->
   <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
   <link href="<?= base_url(); ?>assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
   <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap"
      rel="stylesheet">
   <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url(); ?>assets/css/select2.min.css">
   <link rel="stylesheet" href="<?= base_url(); ?>assets/css/select2-bootstrap-5-theme.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

   <!--main css-->
   <link href="<?= base_url(); ?>assets/css/bootstrap-extended.css" rel="stylesheet">
   <link href="<?= base_url(); ?>sass/main.css" rel="stylesheet">
   <link href="<?= base_url(); ?>sass/dark-theme.css" rel="stylesheet">
   <link href="<?= base_url(); ?>sass/semi-dark.css" rel="stylesheet">
   <link href="<?= base_url(); ?>sass/bordered-theme.css" rel="stylesheet">
   <link href="<?= base_url(); ?>sass/responsive.css" rel="stylesheet">
</head>

<body>
   <style>
      .select2-container--default .select2-selection--single {
         padding: 10px;
         /* Adjust the padding value as needed */
      }

      .select2-container--default .select2-selection--single .select2-selection__placeholder {
         padding: 10px;
         /* Adjust the padding value as needed */
      }
   </style>
   <div id="overlay"
      style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000;">
   </div>
   <div id="loader"
      style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1001;">
      <img src="<?= base_url(); ?>assets/images/loda.gif" alt="Loading..." style="opacity:0.5">
   </div>
   <!--start header-->
   <header class="top-header">
      <nav class="navbar navbar-expand align-items-center gap-4">
         <div class="btn-toggle">
            <a href="javascript:;"><i class="material-icons-outlined">menu</i></a>
         </div>
         <div class="search-bar flex-grow-1">
            <div class="position-relative">
                        <span
                  class="material-icons-outlined position-absolute me-3 translate-middle-y end-0 top-50 search-close">close</span>
               <div class="search-popup p-3">
                  <div class="card rounded-4 overflow-hidden">
                     <div class="card-header d-lg-none">
                        <div class="position-relative">
                           <input class="form-control rounded-5 px-5 mobile-search-control" type="text"
                              placeholder="Search">
                           <span
                              class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50">search</span>
                           <span
                              class="material-icons-outlined position-absolute me-3 translate-middle-y end-0 top-50 mobile-search-close">close</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>


         <ul class="navbar-nav gap-1 nav-right-links align-items-center">
            <li class="nav-item dropdown">
               <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                  <h5 class="user-name mb-0 fw-bold">
                     <?= $this->session->userdata('name'); ?>
                  </h5>
               </a>
               <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">
                  <!-- <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                     href="<?= base_url(); ?>User/view/<?= $this->session->userdata('user_id'); ?>"><i
                        class=" material-icons-outlined">person_outline</i>Profile</a> -->
                  <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                     href="<?= base_url(); ?>User/change_password"><i
                        class="material-icons-outlined">local_bar</i>Change Password</a>
                  <hr class="dropdown-divider">
                  <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="<?= base_url(); ?>"><i
                        class="material-icons-outlined">power_settings_new</i>Logout</a>
               </div>
            </li>
         </ul>
      </nav>
   </header>