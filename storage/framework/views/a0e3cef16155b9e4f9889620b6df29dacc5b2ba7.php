<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="<?php echo e(asset('img/favicon.png')); ?>" rel="shortcut icon" />
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <?php echo $__env->yieldContent('seo'); ?>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Font Awesome -->
  <!-- Admin Css -->
  <link rel="stylesheet" href="<?php echo e(asset('css/admin-diendien.min.css')); ?>">
  <!-- Admin Custom Css -->
  <link rel="stylesheet" href="<?php echo e(asset('css/style_admin.css')); ?>">
  <!-- Admin js -->
  <script src="<?php echo e(asset('js/admin.diendienv2.js')); ?>"></script>
  <script src="<?php echo e(asset('js/js_admin.js')); ?>"></script>
  <script src="<?php echo e(asset('ckeditor/ckeditor.js')); ?>"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <script type="text/javascript">
    var admin_url = '<?php echo e(route('admin.dashboard')); ?>';
  </script><?php /**PATH C:\xampp\htdocs\Lap-Trinh-Web-Team-Official\resources\views/admin/layouts/header.blade.php ENDPATH**/ ?>