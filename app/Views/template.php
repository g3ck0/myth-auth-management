<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?php echo base_url('assets/template/img/favicon.png') ?>" rel="icon">
    <link href="<?php echo base_url('assets/template/img/apple-touch-icon.png') ?>" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
          rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?php echo base_url('assets/template/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/template/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/template/vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/template/vendor/quill/quill.snow.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/template/vendor/quill/quill.bubble.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/template/vendor/remixicon/remixicon.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/template/vendor/simple-datatables/style.css') ?>" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?php echo base_url('assets/template/css/style.css') ?>" rel="stylesheet">

    <!-- CSS plugins -->
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/scripts/lou-multi-select/css/multi-select.css')?>"/>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css"/>

    <!-- TOASTR -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- SWEETALERT -->
    <link href="<?=base_url()?>/assets/scripts/sweetalert2/sweetalert2.css" rel="stylesheet">
    <!-- =======================================================
    * Template Name: NiceAdmin - v2.2.0
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
    <style>
        .thumb_animales{
            width:100%;
            max-width:200px;
        }

        .input-file-container {
            position: relative;
            width: 300px;
        }
        .input-file-trigger {
            /*display: block;
            cursor: pointer;
            padding: 14px 45px;
            background: #39D2B4;
            color: #fff;
            font-size: 1em;
            transition: all .4s;*/
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            color: #0d6efd;
            border-color: #0d6efd;
        }
        .input-file {
            position: absolute;
            top: 0; left: 0;
            width: 225px;
            opacity: 0;
            padding: 14px 0;
            cursor: pointer;
        }
        .input-file:hover + .input-file-trigger,
        .input-file:focus + .input-file-trigger,
        .input-file-trigger:hover,
        .input-file-trigger:focus {
            /*background: #34495E;
            color: #39D2B4;*/
            color: #fff;
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .file-return {
            margin: 0;
        }
        .file-return:not(:empty) {
            margin: 1em 0;
        }
        .file-return {
            font-style: italic;
            font-size: .9em;
            font-weight: bold;
        }
        .file-return:not(:empty):before {
            content: "Selected file: ";
            font-style: normal;
            font-weight: normal;
        }


    </style>
    <?= $this->renderSection('javascript_head') ?>
</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <img src="<?php echo base_url('assets/template/img/logo.png') ?>" alt="">
            <span class="d-none d-lg-block">NiceAdmin</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="<?php echo base_url('assets/template/img/profile-img.jpg') ?>" alt="Profile"
                         class="rounded-circle profilePhoto">
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <?php
                        $user = user();
                        ?>
                        <h6><?= $user->email ?></h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?= base_url('admin/perfil/') ?>">
                            <i class="bi bi-person"></i>
                            <span>Mi Perfil</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('admin/logout') ?>">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Salir</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="<?= base_url()?>">
                <i class="bi bi-grid"></i>
                <span>Start Page</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#usuarios-nav" data-bs-toggle="collapse" href="#">
                <i class="ri-admin-fill"></i><span>Management</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="usuarios-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <?= anchor(base_url(route_to('users')), 'Users') ?>
                </li>
                <li>
                    <?= anchor(base_url(route_to('roles')), 'Roles') ?>
                </li>
                <li>
                    <?= anchor(base_url(route_to('permissions')), 'Permissions') ?>
                </li>
            </ul>
        </li><!-- End Users Nav -->
    </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">

    <?= $this->renderSection('content') ?>


</main><!-- End #main -->
<?= $this->renderSection('modals') ?>
<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="<?php echo base_url('assets/template/vendor/apexcharts/apexcharts.min.js') ?>"></script>
<script src="<?php echo base_url('assets/template/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?php echo base_url('assets/template/vendor/chart.js/chart.min.js') ?>"></script>
<script src="<?php echo base_url('assets/template/vendor/echarts/echarts.min.js') ?>"></script>
<script src="<?php echo base_url('assets/template/vendor/quill/quill.min.js') ?>"></script>
<script src="<?php echo base_url('assets/template/vendor/simple-datatables/simple-datatables.js') ?>"></script>
<script src="<?php echo base_url('assets/template/vendor/tinymce/tinymce.min.js') ?>"></script>
<script src="<?php echo base_url('assets/template/vendor/php-email-form/validate.js') ?>"></script>

<!-- Template Main JS File -->
<script src="<?php echo base_url('assets/template/js/main.js') ?>"></script>

<!-- plug ins -->
<script src="<?php echo base_url('assets/jquery/jquery-3.1.1.min.js')?>" type="text/javascript"></script>

<!--<script type="text/javascript" src="<?php echo base_url('assets/DataTables/datatables.min.js')?>"></script>-->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

<script type="text/javascript" src="<?php echo base_url('assets/scripts/lou-multi-select/js/jquery.multi-select.js')?>"></script>

<!-- TOASTR -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- SWEETALERT -->
<script type="text/javascript" src="<?=base_url()?>/assets/scripts/sweetalert2/sweetalert2.js"></script>

<!-- jquery-validation -->
<script src="https://adminlte.io/themes/v3/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="https://adminlte.io/themes/v3/plugins/jquery-validation/additional-methods.min.js"></script>


<?= $this->renderSection('javascript') ?>

<script type="text/javascript">

    function msg_ok(text) { //Abram:
        toastr.options = {
            closeButton: false,
            debug: false,
            positionClass: 'toast-top-right',
            onclick: null,
            showDuration: 1000,
            hideDuration: 1000,
            timeOut: 5000,
            extendedTimeOut: 1000,
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };
        toastr['success'](text, 'Notification');
    };

    function msg_error(text) {
        toastr.options = {
            closeButton: false,
            debug: false,
            positionClass: 'toast-top-right',
            onclick: null,
            showDuration: 1000,
            hideDuration: 1000,
            timeOut: 5000,
            extendedTimeOut: 1000,
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut'
        };
        toastr['error'](text, 'Conflict');
    };

    function stick_error(title, text)
    {
        toastr.options = {
            closeButton: false,
            debug: false,
            newestOnTop: true,
            progressBar: false,
            positionClass: "toast-top-right",
            preventDuplicates: false,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "-1",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        };
        toastr["error"](text, title);
    }

    function stick_warning(title, text)
    {
        toastr.options = {
            closeButton: false,
            debug: false,
            newestOnTop: true,
            progressBar: false,
            positionClass: "toast-top-right",
            preventDuplicates: false,
            onclick: null,
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "-1",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        };
        toastr["warning"](text, title);
    }

    function clean_errors()
    {
        $('.is-invalid').parent().find('span').html('');
        $('.is-invalid').parent().find('span').removeClass('invalid-feedback');
        $('.is-invalid').removeClass('is-invalid');
        $('.is-valid').removeClass('is-valid');
    }

    function clean_form(forma)
    {
        clean_errors();
        $('#'+forma)[0].reset(); // reset form on modals
    }

    function check_errors(padre, errors)
    {
        $.each(errors, function(index, value)
        {
            if(value !== '')
            {
                $(padre + " [name='"+index+"']").addClass('is-invalid');
                $(padre + " [name='"+index+"']").parent().find('span').addClass('invalid-feedback');
                $(padre + " [name='"+index+"']").parent().find('span').html(value);
            }
            else
            {
                $(padre + " [name='"+index+"']").addClass('is-valid');
                $(padre + " [name='"+index+"']").parent().find('span').html('');
            }
        });
    }

</script>

</body>

</html>