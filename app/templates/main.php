<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> <?php echo APPLICATION_TITLE . ' | ' . $title; ?> </title>
  <link rel="shortcut icon" href="<?php echo URL ?>/assets/images/icon.png" type="image/png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo URL ?>/assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo URL ?>/assets/css/adminlte.min.css">
  <?php \core\Style::show(); ?>

</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse layout-navbar-fixed layout-footer-fixed">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-navy navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item ">
          <a href="<?php echo \core\Action::get()->getUrl(); ?>" class="nav-link" title="Início"><i class="fas fa-home"></i>
            <span class="d-none d-sm-inline-block">Início</span> </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link" title="Suporte"><i class="fas fa-question-circle"></i>
            <span class=" d-none d-sm-inline-block">Suporte</span></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <!-- Messages Dropdown Menu -->
        <li class="nav-item">
          <a href="<?php echo \core\Action::get('Login', 'logout')->getUrl(); ?>" class="nav-link" title="Clicque para sair"><i class="fas fa-sign-out-alt"></i>
            <span class=" d-none d-sm-inline-block">Sair</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->
    <?php
    $menu = $component(\components\Menu::class, []);
    $menu->show();
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1><?php echo $title; ?></h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <section class="content p-1">
        <?php
        \components\Alert::getFlashMessage();
        include $view;
        ?>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer bg-navy">
      <div class="float-right d-none d-sm-block text-gray">
        <b>Versão</b> <?php echo APPLICATION_VERSION; ?>
      </div>
      <strong class="text-gray">&copy; 2021 MaisEdu - <a href="http://www.ifto.edu.br/pedroafonso">
          IFTO</a>.</strong> <span class="text-gray">Todos os direitos reservados</span>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <?php components\ButtonConfirmationModal::getModal(); ?>
  <!-- jQuery -->
  <script src="<?php echo URL ?>/assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo URL ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo URL ?>/assets/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <?php \core\Script::show(); ?>
</body>

</html>