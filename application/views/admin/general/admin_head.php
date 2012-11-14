<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php echo $title; ?></title>
  <meta name="description" content="<?php echo (isset($meta_desc)) ? $meta_desc : ''; ?>">

  <meta name="viewport" content="width=device-width">
  <meta name="robots" content="noindex">

  <link rel='stylesheet' href="<?php echo base_url(); ?>resources/css/base-styles.min.css" type="text/css">
  <link rel='stylesheet' href="<?php echo base_url(); ?>resources/css/admin/admin-style.css" type="text/css">

  <?php if(isset($head_scripts) && !empty($head_scripts)) {
      if(is_array($head_scripts)) { foreach ($head_scripts as $script) { echo $script; } } else { echo $head_scripts; }
  } ?>
  
</head>
<body>
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->