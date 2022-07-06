<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo APPLICATION_TITLE.' | '.$title;?></title>
  <link rel="shortcut icon" href="<?php echo URL?>/assets/images/icon.png" type="image/png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo URL?>/assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo URL?>/assets/css/adminlte.min.css">
  <?php \core\Style::show();?>
</head>
<body class="hold-transition login-page">
  <?php include $view?>
<!-- jQuery -->
<script src="<?php echo URL?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo URL?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo URL?>/assets/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
  <?php \core\Script::show();?>
</body>
</html>
